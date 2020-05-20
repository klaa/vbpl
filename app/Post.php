<?php

namespace App;

use App\Scopes\PostTypeScope;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = true;
    protected $table = 'posts';
    protected $fillable = ['category_id','alias','published','user_id','is_featured','ordering','post_type'];
    public function category() {
        return $this->belongsTo('App\Category');
    }
    public function post_details() {
        return $this->hasMany('App\PostDetail','post_id','id');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function media() {
        return $this->morphMany('App\Media', 'mediable');
    }
    protected static function booted()
    {
        static::addGlobalScope(new PostTypeScope);
    }
    public function getRouteKeyName()
    {
        return 'alias';
    }
    public function ruleForCreating() {
        return [
            'name'                  => 'required',
            'alias'                 => 'required|unique:posts',
            'category_id'           => 'numeric',
            'body'                  => 'required',
            'published'             => 'numeric',
            'is_featured'           => 'numeric',
            'ordering'              => 'nullable|numeric',
            'title'                 => 'nullable|string',
            'keywords'              => 'nullable|string',
            'desc'                  => 'nullable|string',
        ];
    }
    public function ruleForEditting() {
        $rules = $this->ruleForCreating();
        $rules['alias'] = 'required|unique:posts,alias,'.$this->id;
        return $rules;
    }
}
