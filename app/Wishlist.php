<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['customer_id', 'created_at', 'updated_at'];

  /**
   * Get the artworks
   */
  public function artworks() {
    return $this->belongsToMany('App\Artwork', 'artwork_wishlists', 'wishlist_id'); 
  }
}
