<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArtworkCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['artwork_id', 'category_id'];
}