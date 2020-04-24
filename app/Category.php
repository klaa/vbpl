<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['parent_id','published','category_type','ordering'];
    public function category_details() {
        return $this->hasMany('App\CategoryDetail');
    }
    public function posts() {
        return $this->hasMany('App\Post');
    }
    public function parent() {
        return $this->belongsTo('App\Category','parent_id','id');
    }
    public function children() {
        return $this->hasMany('App\Category','parent_id','id');
    }
    public function getAllCategoriesByType($type = 'post') {
        if(empty($this->id)) return null;
        $data = collect([$this]);
        $this->addChildToCollection($this,$data);
        return $data;
    }
    public function addChildToCollection(Category $item,$data) {
        if(!empty($item->children)) {
            $item->children->each(function($v) use ($data) {
                $data->push($v);
                $this->addChildToCollection($v,$data);
            });
        }  
    }
}
