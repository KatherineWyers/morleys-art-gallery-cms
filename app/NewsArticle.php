<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content', 'img_1', 'created_at', 'updated_at'];

    public function publication_date() 
    {
        return date('D d-M-Y', strtotime($this->created_at)) ;
    }
}
