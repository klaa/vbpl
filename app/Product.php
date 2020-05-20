<?php

namespace App;
use App\Post;

class Product extends Post
{
    public function product_details() {
        return $this->hasMany('App\ProductDetail','post_id','id');
    }
    public function ruleForCreating() {
        $rules = parent::ruleForCreating();
        $rules = array_merge($rules,[
            "prices.*.price"         => "nullable|numeric",
            "prices.*.base_price"    => "nullable|numeric",
            "prices.*.varriant_name" => "nullable|string",
            "prices.*.code"          => "nullable|string",
            "prices.*.quantity"      => "nullable|numeric",
            "prices.*.unit"          => "nullable|string",
        ]);
        return $rules;
    }
}
