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
    protected $fillable = ['title', 'artist_id', 'year_created', 'medium', 'width_cm', 'height_cm', 'width_in', 'height_in', 'price_gbp', 'img_1', 'img_2', 'img_3', 'desc_1', 'created_at', 'updated_at'];


  /**
   * Get the artist    
   */
  public function artist() {
    return $this->belongsTo('App\Artist');
  }

  /**
   * Get the categories    
   */
  public function categories() {
    return $this->belongsToMany('App\Category', 'artwork_categories', 'artwork_id');
  }

}