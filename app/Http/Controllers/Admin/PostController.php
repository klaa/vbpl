<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use stdClass;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with('category_details')->where([['published','=',1],['category_type','=','post']])->get();
        return view('admin.posts.create',compact('categories'));
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
        if(empty($request->user_id)) {            
            $request->merge(['user_id'=>auth()->user()->id]);
        }
        $request->merge(['language'=>'vn']);
        $validatedData = $request->validate([
            'name'      => ['required'],
            'alias'     => ['required','unique:post_details'],
            'body'      => ['required'],
        ]);
        $post = new Post($request->only(['category_id','published','user_id','is_featured','ordering']));
        if($post->save()) {
            $post->post_details()->create($request->only(['name','alias','body','desc','keywords','title','language']));
            $msg = __('admin.update_post_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = 'admin.posts.index';
        $param = [];
        if($request->task=='save') {
            $routename = 'admin.posts.edit';
            $param  = $post;
        }
        return redirect()->route($routename,$param)->with($msg_type,$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::with('category_details')->where([['published','=',1],['category_type','=','post']])->get();
        return view('admin.posts.edit',compact(['categories','post']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if(empty($request->alias)) {            
            $request->merge(['alias'=>Str::slug($request->name)]);
        }
        if(empty($request->user_id)) {            
            $request->merge(['user_id'=>auth()->user()->id]);
        }
        $request->merge(['language'=>'vn']);
        $validatedData = $request->validate([
            'name'      => ['required'],
            'alias'     => ['required','unique:post_details,alias,'.$post->id.',post_id'],
            'body'      => ['required'],
        ]);
        if($post->update($request->only(['category_id','published','user_id','is_featured','ordering']))) {
            $post->post_details()->update($request->only(['name','alias','body','desc','keywords','title','language']));
            $msg = __('admin.update_post_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = 'admin.posts.index';
        $param = [];
        if($request->task=='save') {
            $routename = 'admin.posts.edit';
            $param  = $post;
        }
        return redirect()->route($routename,$param)->with($msg_type,$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $name = $post->post_details->first()->name;
        DB::table('post_details')->where('post_id','=',$post->id)->delete();
        if($post->delete()) {
            $message = __('admin.post_deleted',compact('name'));
            $message_state = 'success';
        }else{
            $message = __('admin.action_failed');
            $message_state = 'error';
        }
        return redirect()->route('admin.posts.index')->with($message_state,$message);
    }

    /**
     * Prepare data for datatable ajax request
     * @return JSON 
     */
    public function getDatatable() {
        $this->authorize('viewAny',auth()->user());
        $items = Post::with('post_details')->get(['id','published'])->map(function($item) {
            $name   = '<a href="'.route('admin.posts.edit',$item).'">'.$item->post_details->first()->name.'</a>';
            $alias  = $item->post_details->first()->alias;
            if($item->published) {
                $pbtn = '<a href="'.route('admin.posts.publish',$item).'" class="text-success"><i class="far fa-check-circle"></i></a>';
            }else{
                $pbtn = '<a href="'.route('admin.posts.publish',$item).'" class="text-danger"><i class="far fa-times-circle"></i></a>';
            }
            $action = '<a href="'.route('admin.posts.edit',$item).'" class="btn btn-info btn-sm"><i class="far fa-edit fa-sm"></i></a> <a data-action="'.route('admin.posts.destroy',$item).'" href="#deleteModal" data-toggle="modal" class="btn btn-danger btn-sm deleteButton"><i class="fas fa-trash fa-sm"></i></a>';
            return [$item->id,$name,$alias,$pbtn,$action];
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
    public function publish(Post $post) {
        $this->authorize('update',auth()->user()); 
        if($post->published) {
            $post->published = 0;
        }else{
            $post->published = 1;
        }
        if($post->save()) {
            $message = __('admin.post_publish_changed');
            $message_state = 'success';
        }else{
            $message = __('admin.action_failed');
            $message_state = 'error';
        }
        return redirect()->route('admin.posts.index')->with($message_state,$message);
    }
}
