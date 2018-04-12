<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Sale;
use App\OnlineSale;
use App\Artwork;
use App\User;
use App\Wishlist;
use Auth;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Visit;


class SalesController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('ismanageroradmin', ['except' => ['wishlistSale', 'storeOnlineSale']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $current_user = User::find(Auth::user()->id);
        if($current_user->isManager() == TRUE){
            $users = User::all();            
        } else {
            $users = User::where('id', '=', $current_user->id)->get();
        }
        return view('ims.sales.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($artwork_id)
    {
        $artwork=Artwork::find($artwork_id);

        if($artwork->visible==FALSE) {
            // item is not visible
            return redirect('/');
        }

        $featured_img = $artwork->img_1;
        return view('ims.pos.create-sale', compact('artwork', 'featured_img'));
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
            'name' => 'required|max:30',
            'email' => 'max:100',
            'phone_number' => 'max:100',
            'seller_id' => 'required|exists:users,id',
            'artwork_id' => 'required|exists:artworks,id'
        ]);

        $sale=$request->all();
        $sale = Sale::create($sale);

        $artwork = Artwork::find($sale->artwork_id);
        $artwork->visible = FALSE;
        $artwork->save();

        return redirect('/ims/sales');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function wishlistSale(Request $request, $artwork_id, $wishlist_id)
    {
        $artwork=Artwork::find($artwork_id);
        $wishlist=Wishlist::find($wishlist_id);

        if($artwork->visible==FALSE) {
            // item is not visible
            return redirect('/wishlists/' . $wishlist->id);
        }

        $featured_img = $artwork->img_1;

        $response = response()->view('web-portal.pos.create-wishlist-sale', compact('artwork', 'featured_img', 'wishlist'));
        return $this->handleVisit($request, $response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOnlineSale(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required|exists:users,id',
            'artwork_id' => 'required|exists:artworks,id',
            'purchaser_name' => 'required|max:30',
            'purchaser_email' => 'max:100',
            'cc_name' => 'required|max:30',
            'cc_number' => 'required|max:19',
            'cc_exp_mm' => 'required|max:2',
            'cc_exp_yyyy' => 'required|max:4',
            'cc_cvv' => 'required|max:3',
        ]);

        //process credit card transaction with merchant services API
        //credit card details are never stored

        $online_sale=$request->all();
        $online_sale = OnlineSale::create($online_sale);

        $artwork = Artwork::find($online_sale->artwork_id);
        $artwork->visible = FALSE;
        $artwork->save();

        $customer = User::find($request->input('customer_id'));

        \Session::flash('flash_message', 'Item purchased successfully. It is now available for collection by ' . $customer->name . ' at the gallery. Thank you');

        return redirect('/');
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
