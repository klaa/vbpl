<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use stdClass;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Category::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.productcategories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with('category_details')->where([['published',1],['category_type','product']])->get();
        return view('admin.productcategories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->alias)) {            
            $request->merge(['alias'=>Str::slug($request->name)]);
        }
        $request->merge(['category_type'=>'product','language'=>'vn']);
        $validatedData = $request->validate([
            'name'      => ['required'],
            'alias'     => ['required','unique:category_details'],
        ]);
        
        $productcategory = new Category($request->only(['parent_id','alias','published','category_type']));
        if($productcategory->save()) {
            $productcategory->category_details()->create($request->only(['name','desc','keywords','title','language']));
            $msg = __('admin.update_category_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = 'admin.productcategories.index';
        $param = [];
        if($request->task=='save') {
            $routename = 'admin.productcategories.edit';
            $param  = $productcategory;
        }
        return redirect()->route($routename,$param)->with($msg_type,$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $productcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Category $productcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $productcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $productcategory)
    {
        $childlist = $productcategory->getAllCategoriesByType('product');
        $childlist = $childlist->pluck('id')->all();
        $categories = Category::with('category_details')->where([['published',1],['category_type','product']])->whereNotIn('id',$childlist)->get();
        return view('admin.productcategories.edit',compact(['categories','productcategory']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $productcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $productcategory)
    {
        if(empty($request->alias)) {            
            $request->merge(['alias'=>Str::slug($request->name)]);
        }
        $request->merge(['category_type'=>'product','language'=>'vn']);
        $validatedData = $request->validate([
            'name'      => ['required'],
            'alias'     => ['required','unique:category_details,alias,'.$productcategory->id.',category_id'],
        ]);
 
        if($productcategory->update($request->only(['parent_id','alias','published','category_type']))) {
            $productcategory->category_details()->update($request->only(['name','desc','keywords','title','language']));
            $msg = __('admin.update_category_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = 'admin.productcategories.index';
        $param = [];
        if($request->task=='save') {
            $routename = 'admin.productcategories.edit';
            $param  = $productcategory;
        }
        return redirect()->route($routename,$param)->with($msg_type,$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $productcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $productcategory)
    {
        $name = $productcategory->category_details->first()->name;
        DB::table('category_details')->where('category_id','=',$productcategory->id)->delete();
        if($productcategory->delete()) {
            $message = __('admin.category_deleted',compact('name'));
            $message_state = 'success';
        }else{
            $message = __('admin.action_failed');
            $message_state = 'error';
        }
        return redirect()->route('admin.productcategories.index')->with($message_state,$message);
    }
    
    /**
     * Prepare data for datatable ajax request
     * @return JSON 
     */
    public function getDatatable() {
        $this->authorize('viewAny',auth()->user());
        $items = Category::with('category_details')->where([['category_type','product']])->get()->map(function($item) {
            $name   = '<a href="'.route('admin.productcategories.edit',$item).'">'.$item->category_details->first()->name.'</a>';
            if($item->published) {
                $pbtn = '<a href="'.route('admin.productcategories.publish',$item).'" class="text-success"><i class="far fa-check-circle"></i></a>';
            }else{
                $pbtn = '<a href="'.route('admin.productcategories.publish',$item).'" class="text-danger"><i class="far fa-times-circle"></i></a>';
            }
            $action = '<a href="'.route('admin.productcategories.edit',$item).'" class="btn btn-info btn-sm"><i class="far fa-edit fa-sm"></i></a> <a data-action="'.route('admin.productcategories.destroy',$item).'" href="#deleteModal" data-toggle="modal" class="btn btn-danger btn-sm deleteButton"><i class="fas fa-trash fa-sm"></i></a>';
            return [$item->id,$name,$item->ordering,$pbtn,$action];
        });
        $response = new stdClass;
        $response->data = $items;
        return response(json_encode($response))->header('Content-Type', 'application/json');
    }

    /**
     * Change published status of user
     * @param App\Category
     * @return View
     */
    public function publish(Category $productcategory) {
        $this->authorize('update',auth()->user()); 
        if($productcategory->published) {
            $productcategory->published = 0;
        }else{
            $productcategory->published = 1;
        }
        if($productcategory->save()) {
            $message = __('admin.category_publish_changed');
            $message_state = 'success';
        }else{
            $message = __('admin.action_failed');
            $message_state = 'error';
        }
        return redirect()->route('admin.productcategories.index')->with($message_state,$message);
    }
}
