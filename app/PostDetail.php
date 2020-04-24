<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostDetail extends Model
{
    protected $fillable = ['name','alias','body','desc','keywords','title','language'];
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
