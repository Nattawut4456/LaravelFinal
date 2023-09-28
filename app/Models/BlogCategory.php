<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class BlogCategory extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function blog(){
        return $this->belongsTo('App\Models\Blog');
    }
}
