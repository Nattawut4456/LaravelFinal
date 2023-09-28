<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    public function blogCategories(){
        return $this->hasMany('App\Models\BlogCategory','blog_id','id');
    }

    public function favourites(){
        return $this->hasMany('App\Models\Favourite','blog_id','id');
    }
    
    public function comments(){
        return $this->hasMany('App\Models\Comment','blog_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
