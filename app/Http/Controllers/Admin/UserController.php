<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use stdClass;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$items = User::all();
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::all();
        return view('admin.users.create',compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required'],
            'email' => ['required','email','unique:users'],
            'username' => ['required','unique:users'],
            'password' => ['required','min:8'],
        ];
        $validatedData = $request->validate($rules);

        $excude_index = array('_token','_method','task');

        if(empty($request->phone)) {
            $excude_index[] = 'phone';
        }

        $user = new User($request->except($excude_index));

        if($user->save()) {
            $msg = __('admin.update_user_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }

        $this->assignGroup($request,$user);

        $route_name = 'admin.users.index';
        if($request->task=='save') {
            $route_name = 'admin.users.edit';
        }

        return redirect()->route($route_name,$user)->with($msg_type,$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $groups = Group::all();
        return view('admin.users.edit',compact('user','groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required'],
            'email' => ['required','email','unique:users,email,'.$user->id],
            'username' => ['required','unique:users,username,'.$user->id],
            'password' => ['nullable','min:8'],
        ];
        $validatedData = $request->validate($rules);

        $this->assignGroup($request,$user);

        $excude_index = array('_token','_method','task','groups');

        if(empty($request->password)) {
            $excude_index[] = 'password';
        }
        if(empty($request->phone)) {
            $excude_index[] = 'phone';
        }

        if($user->update($request->except($excude_index))) {
            $msg = __('admin.update_user_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $route_name = 'admin.users.index';
        $param = [];
        if($request->task=='save') {
            $route_name = 'admin.users.edit';
            $param = $user;
        }

        return redirect()->route($route_name,$param)->with($msg_type,$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //Delete post

        //Delete group link
        $user->groups()->detach();

        //Delete user
        $name = $user->name;
        if($user->delete()) {
            $message = __('admin.user_deleted',compact('name'));
            $message_state = 'success';
        }else{
            $message = __('admin.action_failed');
            $message_state = 'error';
        }
        return redirect()->route('admin.users.index')->with($message_state,$message);
    }

    /** 
    *   Get all items for datatable
    *   @return JSON
    */
    public function getDatatable() {
        $this->authorize('viewAny',auth()->user());
        $items = User::with('groups')->get()->map(function($item) {
            $group  = $item->groups->implode('name',', ');
            $name   = '<a href="'.route('admin.users.edit',$item).'">'.$item->name.'</a>';
            $email  = '<a href="'.route('admin.users.edit',$item).'">'.$item->email.'</a>';
            $action = '<a href="'.route('admin.users.edit',$item).'" class="btn btn-info btn-sm"><i class="far fa-edit fa-sm"></i></a> <a data-action="'.route('admin.users.destroy',$item).'" href="#deleteModal" data-toggle="modal" class="btn btn-danger btn-sm deleteButton"><i class="fas fa-trash fa-sm"></i></a>';
            if($item->published) {
                $pbtn = '<a href="'.route('admin.users.publish',$item).'" class="text-success"><i class="far fa-check-circle"></i></a>';
            }else{
                $pbtn = '<a href="'.route('admin.users.publish',$item).'" class="text-danger"><i class="far fa-times-circle"></i></a>';
            }
            return [$item->id,$name,$email,$group,$pbtn,$action];
        });
        $response = new stdClass;
        $response->data = $items;
        return response(json_encode($response))->header('Content-Type', 'application/json');
    }
    
    /**
     * Change published status of user
     * @param App\User
     * @return View
     */
    public function publish(User $user) {
        $this->authorize('update',auth()->user()); 
        if($user->published) {
            $user->published = 0;
        }else{
            $user->published = 1;
        }
        if($user->save()) {
            $message = __('admin.user_publish_changed');
            $message_state = 'success';
        }else{
            $message = __('admin.action_failed');
            $message_state = 'error';
        }
        return redirect()->route('admin.users.index')->with($message_state,$message);
    }

    /**
     * Assign user to groups
     * @param Request $request
     * @param User    $user
     * @return void 
     */
    public function assignGroup(Request $request,User $user) {
        $u = collect($user->groups->all())->pluck('id');
        $r = collect($request->groups);
        
        if($u->diff($r)->count()>0 || $r->diff($u)->count()>0) {
            if(!empty($request->groups) && auth()->user()->can('assignGroup')) {
                $user->groups()->sync($request->groups);
            }else{
                $request->session()->flash('error', __('admin.you_can_not_assign_group'));
            }
        }        
    }
}
