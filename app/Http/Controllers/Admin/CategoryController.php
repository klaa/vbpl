<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use stdClass;

class CategoryController extends Controller
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
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with('category_details')->where([['published',1],['category_type','post']])->get();
        return view('admin.categories.create',compact('categories'));
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
        $request->merge(['category_type'=>'post','language'=>'vn']);
        $validatedData = $request->validate([
            'name'      => ['required'],
            'alias'     => ['required','unique:category_details'],
        ]);
        
        $category = new Category($request->only(['parent_id','published','category_type']));
        if($category->save()) {
            $category->category_details()->create($request->only(['name','alias','desc','keywords','title','language']));
            $msg = __('admin.update_category_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = 'admin.categories.index';
        $param = [];
        if($request->task=='save') {
            $routename = 'admin.categories.edit';
            $param  = $category;
        }
        return redirect()->route($routename,$param)->with($msg_type,$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $childlist = $category->getAllCategoriesByType();
        $childlist = $childlist->pluck('id')->all();
        $categories = Category::with('category_details')->where([['published',1],['category_type','post']])->whereNotIn('id',$childlist)->get();
        return view('admin.categories.edit',compact(['categories','category']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if(empty($request->alias)) {            
            $request->merge(['alias'=>Str::slug($request->name)]);
        }
        $request->merge(['category_type'=>'post','language'=>'vn']);
        $validatedData = $request->validate([
            'name'      => ['required'],
            'alias'     => ['required','unique:category_details,alias,'.$category->id.',category_id'],
        ]);
 
        if($category->update($request->only(['parent_id','published','category_type']))) {
            $category->category_details()->update($request->only(['name','alias','desc','keywords','title','language']));
            $msg = __('admin.update_category_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = 'admin.categories.index';
        $param = [];
        if($request->task=='save') {
            $routename = 'admin.categories.edit';
            $param  = $category;
        }
        return redirect()->route($routename,$param)->with($msg_type,$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $name = $category->category_details->first()->name;
        DB::table('category_details')->where('category_id','=',$category->id)->delete();
        if($category->delete()) {
            $message = __('admin.category_deleted',compact('name'));
            $message_state = 'success';
        }else{
            $message = __('admin.action_failed');
            $message_state = 'error';
        }
        return redirect()->route('admin.categories.index')->with($message_state,$message);
    }
    
    /**
     * Prepare data for datatable ajax request
     * @return JSON 
     */
    public function getDatatable() {
        $this->authorize('viewAny',auth()->user());
        $items = Category::with('category_details')->where([['category_type','post']])->get(['id','published'])->map(function($item) {
            $name   = '<a href="'.route('admin.categories.edit',$item).'">'.$item->category_details->first()->name.'</a>';
            $alias  = $item->category_details->first()->alias;
            if($item->published) {
                $pbtn = '<a href="'.route('admin.categories.publish',$item).'" class="text-success"><i class="far fa-check-circle"></i></a>';
            }else{
                $pbtn = '<a href="'.route('admin.categories.publish',$item).'" class="text-danger"><i class="far fa-times-circle"></i></a>';
            }
            $action = '<a href="'.route('admin.categories.edit',$item).'" class="btn btn-info btn-sm"><i class="far fa-edit fa-sm"></i></a> <a data-action="'.route('admin.categories.destroy',$item).'" href="#deleteModal" data-toggle="modal" class="btn btn-danger btn-sm deleteButton"><i class="fas fa-trash fa-sm"></i></a>';
            return [$item->id,$name,$alias,$pbtn,$action];
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
    public function publish(Category $category) {
        $this->authorize('update',auth()->user()); 
        if($category->published) {
            $category->published = 0;
        }else{
            $category->published = 1;
        }
        if($category->save()) {
            $message = __('admin.category_publish_changed');
            $message_state = 'success';
        }else{
            $message = __('admin.action_failed');
            $message_state = 'error';
        }
        return redirect()->route('admin.categories.index')->with($message_state,$message);
    }
}
