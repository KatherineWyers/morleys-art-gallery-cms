<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;

class Visitor extends Authenticatable
{
    use Notifiable;

    /**
     * hasWishlist
     *
     * @return boolean
     */
    public function hasWishlist()
    {
        $wishlist = DB::table('wishlists')->where('visitor_id', $this->id)->first();
        if ($wishlist == NULL)
        {
            return false;
        }
        return true;
    }

}
