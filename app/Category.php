<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'title', 'created_at', 'updated_at'];


  /**
   * Get the artworks    
   */
  public function artworks() {
    return $this->belongsToMany('App\Artwork', 'artwork_categories', 'category_id');
  }

}