<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDetail extends Model
{
    protected $fillable = ['language','name','alias','desc','keywords','title'];
    public function category() {
        return $this->belongsTo('App\Category');
    }
}
