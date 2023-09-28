<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BlogCategory;

class Category extends Model
{
    use HasFactory;
    public function blogCategories(){
        return $this->hasMany('App\Models\BlogCategory','category_id','id');
    }
}
