<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CategoryTypeScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // dd(get_class($model));
        switch(get_class($model)) {
            case 'App\Category':
                $type = 'post';
                break;
            case 'App\ProductCategory':
                $type = 'product';
                break;
            case 'App\MenuCategory':
                $type = 'product';
                break;
            default:
                $type = 'post';
                break;
        }
        $builder->where('category_type', '=', $type)->orderBy('ordering','desc');
    }
}