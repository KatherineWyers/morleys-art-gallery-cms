<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'featured_artwork_img_lg', 'featured_artwork_img_sm', 'profile_img', 'created_at', 'updated_at'];
}
