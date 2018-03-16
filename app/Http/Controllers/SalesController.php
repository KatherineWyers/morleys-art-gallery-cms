<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Sale;
use App\Artwork;
use App\User;

class SalesController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('ismanageroradmin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $users = User::all();
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
