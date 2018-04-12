<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Wishlist;
use App\Artwork;
use Carbon\Carbon;
use Auth;

use Illuminate\Support\Facades\DB;

use Mail;

class WishlistsController extends Controller
{

    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * show wishlist
     *
     * @return \Illuminate\Http\Response
     */
    public function myWishlist(Request $request)
    {  
        $wishlist = $this->getWishlist(Auth::user()->id);
        return view('web-portal.wishlists.show', compact('wishlist'));
    }


    /**
     * add Artwork to a wishlist
     *
     * @return \Illuminate\Http\Response
     */
    public function addArtwork(Request $request, $artwork_id)
    {
        $wishlist = $this->getWishlist(Auth::user()->id);

        $artwork = Artwork::find($artwork_id);
        //only add artwork to the wishlist if it has not already been added
        $found = false;
        foreach($wishlist->artworks as $loop_artwork)
        {
            if($loop_artwork->id == $artwork->id)
            {
                $found = true;
                continue;
            }
        }

        if($found)
        {
            \Session::flash('flash_message','Artwork already added to your wishlist');
        }
        else
        {
            $wishlist->artworks()->save($artwork); 
        }
           
            
        return redirect('/wishlists/my_wishlist');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wishlist=Wishlist::find($id);
        return view('web-portal.wishlists.show', compact('wishlist'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:30',
            'email' => 'max:100',
            'wishlist_id' => 'required|exists:wishlists,id'
        ]);

        $user = Auth::user();

        Mail::send('emails.wishlist', ['user' => $user], function ($message) use ($request) {
            $message->from('contact@morleysgallery.com', 'Morleys Gallery');
            $message->to($request->input('email'), $request->input('name'))->subject('Your friend sent a wishlist');
        });

        \Session::flash('flash_message','Your wishlist was sent successfully!');
        return redirect('/wishlists/my_wishlist');
    }

    private function getWishlist($customer_id)
    {
        $wishlist = Wishlist::where('customer_id', '=', $customer_id)->first();
        if($wishlist == NULL)
        {
            $wishlist = Wishlist::create(['customer_id' => $customer_id]);
        }
        return $wishlist; 
    }
}