<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name','alias'];
    public function groups() {
        return $this->belongsToMany(Group::class,'group_permission');
    }
}
