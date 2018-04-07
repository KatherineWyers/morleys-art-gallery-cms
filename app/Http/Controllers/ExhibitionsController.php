<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Exhibition;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Visit;

class ExhibitionsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('ismanageroradmin', ['except' => ['index', 'indexByYear', 'show']]);
    }
    
    public function index(Request $request)
    {        
        $current_exhibitions=Exhibition::current()->get();
        $exhibitions_in_the_next_365_days=Exhibition::inthenext365days()->get();
        $response = response()->view('web-portal.exhibitions.index', compact('current_exhibitions', 'exhibitions_in_the_next_365_days'));
        return $this->handleVisit($request, $response);
    }

    public function indexByYear(Request $request, $yyyy)
    {        
        $exhibitions_by_year=Exhibition::whereYear('start_date', $yyyy)->paginate(10);
        $response = response()->view('web-portal.exhibitions.by_year.index', compact('yyyy', 'exhibitions_by_year'));
        return $this->handleVisit($request, $response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web-portal.exhibitions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:30',
            'start_date' => 'required|date|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
            'img_1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1200,height=300',
            'img_2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=600,height=300',
            'desc_1' => 'required|max:1000',
        ]);

        $exhibition=$request->all();
        $exhibition = Exhibition::create($exhibition);

        if(!is_null(Input::file('img_1'))) {
            $file_img_1 = Input::file('img_1');
            $filename_img_1 = $exhibition->id . '-img_1.' . $file_img_1->getClientOriginalExtension();
            $destinationPath = 'img/exhibitions';
            $uploadSuccess = $file_img_1->move($destinationPath, $filename_img_1);
            $exhibition->img_1 = $exhibition->id . '-img_1.' . $file_img_1->getClientOriginalExtension();
        }
        
        $exhibition->save();

        if(!is_null(Input::file('img_2'))) {
            $file_img_2 = Input::file('img_2');
            $filename_img_2 = $exhibition->id . '-img_2.' . $file_img_2->getClientOriginalExtension();
            $destinationPath = 'img/exhibitions';
            $uploadSuccess = $file_img_2->move($destinationPath, $filename_img_2);
            $exhibition->img_2 = $exhibition->id . '-img_2.' . $file_img_2->getClientOriginalExtension();
        }
        
        $exhibition->save();

        return redirect('/exhibitions/' . $exhibition->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $exhibition=Exhibition::find($id);
        $response = response()->view('web-portal/exhibitions/show', compact('exhibition'));
        return $this->handleVisit($request, $response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exhibition=Exhibition::find($id);
        return view('web-portal.exhibitions.edit',compact('exhibition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:30',
            'start_date' => 'required|date|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
            // images are not required. If they are null, they will not be updated later
            'img_1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1200,height=300',
            'img_2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=600,height=300',
            'desc_1' => 'required|max:1000',
        ]);

        $exhibitionUpdate=$request->all();
        $exhibition=Exhibition::find($id);
        $exhibition->update($exhibitionUpdate);

        if(!is_null(Input::file('img_1'))) {
            $file_img_1 = Input::file('img_1');
            $filename_img_1 = $exhibition->id . '-img_1.' . $file_img_1->getClientOriginalExtension();
            $destinationPath = 'img/exhibitions';
            $uploadSuccess = $file_img_1->move($destinationPath, $filename_img_1);
            $exhibition->img_1 = $exhibition->id . '-img_1.' . $file_img_1->getClientOriginalExtension();
        }
        
        $exhibition->save();

        if(!is_null(Input::file('img_2'))) {
            $file_img_2 = Input::file('img_2');
            $filename_img_2 = $exhibition->id . '-img_2.' . $file_img_2->getClientOriginalExtension();
            $destinationPath = 'img/exhibitions';
            $uploadSuccess = $file_img_2->move($destinationPath, $filename_img_2);
            $exhibition->img_2 = $exhibition->id . '-img_2.' . $file_img_2->getClientOriginalExtension();
        }
        
        $exhibition->save();

        return redirect('/exhibitions/' . $exhibition->id);
    }

    private function handleVisit(Request $request, Response $response){
        $visitor_id = $request->cookie('visitor_id');
        if(is_null($visitor_id)) {
            //log visit by new visitor and set cookie
            $visitor_id = DB::table('visits')->max('visitor_id') + 1;
            $cookie_notification = "We use cookies to ensure that we give you the best experience on our website. If you continue to use the website, we'll assume that you are happy to receive cookies on the Morley's website.";
            \Session::flash('flash_message',$cookie_notification);
            return redirect($request->url())->withCookie(cookie('visitor_id', $visitor_id, 262800));//redirect to this same page without creating a visit
        } else {
            //log visit by cookied visitor
            Visit::create(['visitor_id' => $visitor_id, 'url' => $request->url()]);//create new visit entry
            $response->withCookie(cookie('visitor_id', $visitor_id, 262800));//update the cookie with the new timer
        }
        return $response;
    }
}
