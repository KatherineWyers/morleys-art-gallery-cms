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

}