<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CategoryController;
use App\Category;
use Illuminate\Http\Request;

class MenuCategoryController extends CategoryController
{
    public function __construct()
    {
        // $this->authorizeResource(MenuCategory::class);
        $this->type = 'menu';
        $this->routeList = [
            'datatable'     => 'admin.menucategories.datatable',
            'index'         => 'admin.menucategories.index',
            'create'        => 'admin.menucategories.create',
            'store'         => 'admin.menucategories.store',
            'edit'          => 'admin.menucategories.edit',
            'update'        => 'admin.menucategories.update',
            'destroy'       => 'admin.menucategories.destroy',
            'publish'       => 'admin.menucategories.publish',
        ];
    }
}
