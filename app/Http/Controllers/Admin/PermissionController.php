<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;
use stdClass;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Permission::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::all();
        return view('admin.permissions.create',compact('groups'));
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
        $validatedData = $request->validate([
            'name'      => ['required'],
            'alias'     => ['unique:permissions'],
        ]);
        $item = new Permission($request->only(['name','alias','type']));
        if($item->save()) {
            $item->groups()->sync($request->groups);
            $msg = __('admin.update_permission_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = 'admin.permissions.index';
        $param = [];
        if($request->task=='save') {
            $routename = 'admin.permissions.edit';
            $param  = $item;
        }
        return redirect()->route($routename,$param)->with($msg_type,$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $groups = Group::all();
        return view('admin.permissions.edit',compact('groups','permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        if(empty($request->alias)) {            
            $request->merge(['alias'=>Str::slug($request->name)]);
        }
        $validatedData = $request->validate([
            'name'      => ['required'],
            'alias'     => ['unique:groups,alias,'.$permission->id],
        ]);
        if($permission->update($request->only(['name','alias','type']))) {
            $permission->groups()->sync($request->groups);
            $msg = __('admin.update_group_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = 'admin.permissions.index';
        $param = [];
        if($request->task=='save') {
            $routename = 'admin.permissions.edit';
            $param  = $permission;
        }
        return redirect()->route($routename,$param)->with($msg_type,$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->groups()->detach();
        $name = $permission->name;
        if($permission->delete()) {
            $message = __('admin.group_deleted',compact('name'));
            $message_state = 'success';
        }else{
            $message = __('admin.action_failed');
            $message_state = 'error';
        }
        return redirect()->route('admin.permissions.index')->with($message_state,$message);
    }
    
    /**
     * Prepare data for datatable ajax request
     * @return JSON 
     */
    public function getDatatable() {
        $this->authorize('viewAny',auth()->user());
        $items = Permission::get()->map(function($item) {
            $name   = '<a href="'.route('admin.permissions.edit',$item).'">'.$item->name.'</a>';
            $alias  = '<a href="'.route('admin.permissions.edit',$item).'">'.$item->alias.'</a>';
            $action = '<a href="'.route('admin.permissions.edit',$item).'" class="btn btn-info btn-sm"><i class="far fa-edit fa-sm"></i></a> <a data-action="'.route('admin.permissions.destroy',$item).'" href="#deleteModal" data-toggle="modal" class="btn btn-danger btn-sm deleteButton"><i class="fas fa-trash fa-sm"></i></a>';
            return [$item->id,$name,$alias,$action];
        });
        $response = new stdClass;
        $response->data = $items;
        return response(json_encode($response))->header('Content-Type', 'application/json');
    }
}
