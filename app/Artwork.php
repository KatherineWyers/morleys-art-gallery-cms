<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'artist_id', 'year_created', 'desc_1', 'medium', 'width_cm', 'height_cm', 'width_in', 'height_in', 'price', 'img_1', 'img_2', 'img_3', 'img_sq', 'created_at', 'updated_at'];


  /**
   * Get the artist    
   */
  public function artist() {
    return $this->belongsTo('App\Artist');
  }

  /**
   * Get the wishlists
   */
  public function wishlists() {
    return $this->belongsToMany('App\Wishlist', 'artwork_wishlists', 'artwork_id'); 
  }

  /**
   * Get the categories    
   */
  public function categories() {
    return $this->belongsToMany('App\Category', 'artwork_categories', 'artwork_id'); 
  }
  
  /**
  * hasCategory
  * @param $category_id
  * @return boolean
  */
  public function hasCategory($category_id)
  {
      foreach($this->categories as $category)
      {
          if($category->id == $category_id)
          {
              return true;
          }
      }
      return false;
  }

  public function scopeVisible($query) 
  {
    return $query->where('artworks.visible', TRUE);
  }

  public function scopeNotVisible($query) 
  {
    return $query->where('artworks.visible', FALSE);
  }

  public static function getArtworksFilteredByCategory($category_id)
  {
    if($category_id >= 1 && $category_id <= 6){
      $category = Category::find($category_id);
      $artworks = $category->artworks()->visible();
    } else {
      $artworks = Artwork::visible()->orderBy('created_at', 'desc');
    }
    return $artworks;
  }
}