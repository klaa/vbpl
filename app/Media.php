<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['link','title','content_type','ordering'];
    public function mediable()
    {
        return $this->morphTo();
    }
}
