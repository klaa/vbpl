<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['category_id','published','user_id','is_featured','ordering'];
    public function category() {
        return $this->belongsTo('App\Category');
    }
    public function post_details() {
        return $this->hasMany('App\PostDetail');
    }
}
