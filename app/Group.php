<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name','alias'];

    public function users() {
        return $this->belongsToMany('App\User','user_group');
    }
    public function permissions() {
        return $this->belongsToMany(Permission::class,'group_permission');
    }
}
