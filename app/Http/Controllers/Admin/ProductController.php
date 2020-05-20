<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use stdClass;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with('category_details')->where([['published','=',1],['category_type','=','product']])->get();
        return view('admin.products.create',compact('categories'));
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
            $request->merge(['alias'=>Str::slug($request->get('name'))]);
        }
        if(empty($request->get('user_id'))) {            
            $request->merge(['user_id'=>auth()->user()->id]);
        }
        $request->merge(['post_type'=>'product','language'=>'vn']);
        $product = new Product();

        $validateData = $request->validate($product->ruleForCreating());

        $product->__construct($request->only(['category_id','alias' ,'published','user_id','post_type','is_featured','ordering']));
        if($product->save()) {
            $product->post_details()->create($request->only(['name','body','desc','keywords','title','language']));
            foreach ($request->get('prices') as $value) {
                $product->product_details()->create($value);
            }
            $msg = __('admin.update_product_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = 'admin.products.index';
        $param = [];
        if($request->get('task')=='save') {
            $routename = 'admin.products.edit';
            $param  = $product;
        }
        return redirect()->route($routename,$param)->with($msg_type,$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::with('category_details')->where([['published','=',1],['category_type','=','product']])->get();
        return view('admin.products.edit',compact(['categories','product']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if(empty($request->get('alias'))) {            
            $request->merge(['alias'=>Str::slug($request->get('name'))]);
        }
        $request->merge(['language'=>'vn']);

        $validateData = $request->validate($product->ruleForEditting());     
        
        if($product->update($request->only(['category_id','alias', 'published','is_featured','ordering']))) {
            $product->post_details()->update($request->only(['name','body','desc','keywords','title','language']));
            foreach ($request->get('prices') as $key => $value) {
                $product->product_details()->updateOrCreate(['id'=>$key],$value);
            }
            $msg = __('admin.update_product_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = 'admin.products.index';
        $param = [];
        if($request->get('task')=='save') {
            $routename = 'admin.products.edit';
            $param  = $product;
        }
        return redirect()->route($routename,$param)->with($msg_type,$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $name = $product->post_details->first()->name;
        DB::table('post_details')->where('post_id','=',$product->id)->delete();
        DB::table('product_details')->where('post_id','=',$product->id)->delete();
        if($product->delete()) {
            $message = __('admin.product_deleted',compact('name'));
            $message_state = 'success';
        }else{
            $message = __('admin.action_failed');
            $message_state = 'error';
        }
        return redirect()->route('admin.products.index')->with($message_state,$message);
    }

    /**
     * Prepare data for datatable ajax request
     * @return JSON 
     */
    public function getDatatable() {
        $items = Product::with(['post_details','product_details'])->get();
        $items = $items->map(function($item) {
            $name   = '<a href="'.route('admin.products.edit',$item).'">'.$item->post_details->first()->name.'</a>';
            $alias  = $item->post_details->first()->alias;
            if($item->published) {
                $pbtn = '<a href="'.route('admin.products.publish',$item).'" class="text-success"><i class="far fa-check-circle"></i></a>';
            }else{
                $pbtn = '<a href="'.route('admin.products.publish',$item).'" class="text-danger"><i class="far fa-times-circle"></i></a>';
            }
            $action = '<a href="'.route('admin.products.edit',$item).'" class="btn btn-info btn-sm"><i class="far fa-edit fa-sm"></i></a> <a data-action="'.route('admin.products.destroy',$item).'" href="#deleteModal" data-toggle="modal" class="btn btn-danger btn-sm deleteButton"><i class="fas fa-trash fa-sm"></i></a>';
            return [$item->id,$name,$item->ordering,$pbtn,$action];
        });
        $response = new stdClass;
        $response->data = $items;
        return response(json_encode($response))->header('Content-Type', 'application/json');
    }

    /**
     * Change published status of user
     * @param App\Post
     * @return View
     */
    public function publish(Product $product) {
        if($product->published) {
            $product->published = 0;
        }else{
            $product->published = 1;
        }
        if($product->save()) {
            $message = __('admin.publish_changed');
            $message_state = 'success';
        }else{
            $message = __('admin.action_failed');
            $message_state = 'error';
        }
        return redirect()->route('admin.products.index')->with($message_state,$message);
    }
}
