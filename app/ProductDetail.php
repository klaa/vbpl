<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $fillable = ['post_id','code','varriant_name','base_price','price','quantity','unit'];
    public function post()
    {
        return $this->belongsTo('App\Product');
    }
}
