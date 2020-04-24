<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;
use stdClass;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Group::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.groups.create',compact('permissions'));
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
            'alias'     => ['unique:groups'],
        ]);
        $group = new Group($request->only(['name','alias']));
        if($group->save()) {
            $group->permissions()->sync($request->permissions);
            $msg = __('admin.update_group_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = 'admin.groups.index';
        $param = [];
        if($request->task=='save') {
            $routename = 'admin.groups.edit';
            $param  = $group;
        }
        return redirect()->route($routename,$param)->with($msg_type,$msg);    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $permissions = Permission::all();
        return view('admin.groups.edit',compact('group','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        if(empty($request->alias)) {            
            $request->merge(['alias'=>Str::slug($request->name)]);
        }
        $validatedData = $request->validate([
            'name'      => ['required'],
            'alias'     => ['unique:groups,alias,'.$group->id],
        ]);
        if($group->update($request->only(['name','alias']))) {
            $group->permissions()->sync($request->permissions);
            $msg = __('admin.update_group_success');
            $msg_type = 'success';
        }else{
            $msg = __('admin.action_failed');
            $msg_type = 'error';
        }
        $routename = 'admin.groups.index';
        $param = [];
        if($request->task=='save') {
            $routename = 'admin.groups.edit';
            $param  = $group;
        }
        return redirect()->route($routename,$param)->with($msg_type,$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->permissions()->detach();
        $name = $group->name;
        if($group->delete()) {
            $message = __('admin.group_deleted',compact('name'));
            $message_state = 'success';
        }else{
            $message = __('admin.action_failed');
            $message_state = 'error';
        }
        return redirect()->route('admin.groups.index')->with($message_state,$message);
    }

    /**
     * Prepare data for datatable ajax request
     * @return JSON 
     */
    public function getDatatable() {
        $this->authorize('viewAny',auth()->user());
        $items = Group::with('users')->get(['id','name','alias'])->map(function($item) {
            $name   = '<a href="'.route('admin.groups.edit',$item).'">'.$item->name.'</a>';
            $memberNo  = $item->users->count();
            $action = '<a href="'.route('admin.groups.edit',$item).'" class="btn btn-info btn-sm"><i class="far fa-edit fa-sm"></i></a> <a data-action="'.route('admin.groups.destroy',$item).'" href="#deleteModal" data-toggle="modal" class="btn btn-danger btn-sm deleteButton"><i class="fas fa-trash fa-sm"></i></a>';
            return [$item->id,$name,$memberNo,$action];
        });
        $response = new stdClass;
        $response->data = $items;
        return response(json_encode($response))->header('Content-Type', 'application/json');
    }
}
