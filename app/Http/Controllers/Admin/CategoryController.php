<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use stdClass;

class CategoryController extends Controller
{
    public $type;
    public $routeList;
    public function __construct()
    {
        $this->authorizeResource(Category::class);
        $this->type = 'post';
        $this->routeList = [
            'datatable'     => 'admin.categories.datatable',
            'index'         => 'admin.categories.index',
            'create'        => 'admin.categories.create',
            'store'         => 'admin.categories.store',
            'edit'          => 'admin.categories.edit',
            'update'        => 'admin.categories.update',
            'destroy'       => 'admin.categories.destroy',
            'publish'       => 'admin.categories.publish',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.index',['routeList'=>$this->routeList]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where([['published',1],['category_type',$this->type]])->get();
        return view('admin.categories.create',['categories'=>$categories,'routeList'=>$this->routeList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->get('alias'))) {            
            $request->merge(['alias'=>Str::slug($request->name)]);
        }
        $request->merge(['category_type'=>$this->type,'language'=>'vn']);
        $validatedData = $request->validate([
            'name'      => ['required'],
            'alias'     => ['required','unique:categories'],
        ]);
        
        $category = new Category($request->only(['parent_id','alias','published','category_type','name','desc','keywords','title']));
        if($category->save()) {
            // $category->category_details()->create($request->only(['name','desc','keywords','title','language']));
            $msg = __('admin.update_category_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = $this->routeList['index'];
        $param = [];
        if($request->task=='save') {
            $routename = $this->routeList['edit'];
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
        $categories = Category::where([['published',1],['category_type',$this->type]])->whereNotIn('id',$childlist)->get();
        return view('admin.categories.edit',['categories'=>$categories,'category'=>$category,'routeList'=>$this->routeList]);
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
        $request->merge(['category_type'=>$this->type,'language'=>'vn']);
        $validatedData = $request->validate([
            'name'      => ['required'],
            'alias'     => ['required','unique:categories,alias,'.$category->id.',id'],
        ]);
 
        if($category->update($request->only(['parent_id','alias','published','category_type','name','desc','keywords','title']))) {
            // $category->category_details()->update($request->only(['name','desc','keywords','title','language']));
            $msg = __('admin.update_category_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = $this->routeList['index'];
        $param = [];
        if($request->task=='save') {
            $routename = $this->routeList['edit'];
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
        $name = $category->name;
        DB::table('category_details')->where('category_id','=',$category->id)->delete();
        if($category->delete()) {
            $message = __('admin.category_deleted',compact('name'));
            $message_state = 'success';
        }else{
            $message = __('admin.action_failed');
            $message_state = 'error';
        }
        return redirect()->route($this->routeList['index'],['routeList'=>$this->routeList])->with($message_state,$message);
    }
    
    /**
     * Prepare data for datatable ajax request
     * @return JSON 
     */
    public function getDatatable() {
        $this->authorize('viewAny',auth()->user());
        $items = Category::where('category_type',$this->type)->get()->map(function($item) {
            $name   = '<a href="'.route($this->routeList['edit'],$item).'">'.$item->name.'</a>';
            if($item->published) {
                $pbtn = '<a href="'.route($this->routeList['publish'],$item).'" class="text-success"><i class="far fa-check-circle"></i></a>';
            }else{
                $pbtn = '<a href="'.route($this->routeList['publish'],$item).'" class="text-danger"><i class="far fa-times-circle"></i></a>';
            }
            $action = '<a href="'.route($this->routeList['edit'],$item).'" class="btn btn-info btn-sm"><i class="far fa-edit fa-sm"></i></a> <a data-action="'.route($this->routeList['destroy'],$item).'" href="#deleteModal" data-toggle="modal" class="btn btn-danger btn-sm deleteButton"><i class="fas fa-trash fa-sm"></i></a>';
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
        return redirect()->route($this->routeList['index'])->with($message_state,$message);
    }
}
