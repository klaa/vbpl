<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert(['name'=>'View Dashboard','alias'=>'view-dashboard']);
        
        DB::table('permissions')->insert(['name'=>'View User List','alias'=>'user-viewAny']);
        DB::table('permissions')->insert(['name'=>'View User Detail','alias'=>'user-view']);
        DB::table('permissions')->insert(['name'=>'Create User','alias'=>'user-create']);
        DB::table('permissions')->insert(['name'=>'Edit User','alias'=>'user-update']);
        DB::table('permissions')->insert(['name'=>'Delete User','alias'=>'user-delete']);
        
        DB::table('permissions')->insert(['name'=>'View Group List','alias'=>'group-viewAny']);
        DB::table('permissions')->insert(['name'=>'View Group Detail','alias'=>'group-view']);
        DB::table('permissions')->insert(['name'=>'Create Group','alias'=>'group-create']);
        DB::table('permissions')->insert(['name'=>'Edit Group','alias'=>'group-update']);
        DB::table('permissions')->insert(['name'=>'Delete Group','alias'=>'group-delete']);
        DB::table('permissions')->insert(['name'=>'Assign Group','alias'=>'group-assign']);

        DB::table('permissions')->insert(['name'=>'View Permission List','alias'=>'permission-viewAny']);
        DB::table('permissions')->insert(['name'=>'View Permission Detail','alias'=>'permission-view']);
        DB::table('permissions')->insert(['name'=>'Create Permission','alias'=>'permission-create']);
        DB::table('permissions')->insert(['name'=>'Edit Permission','alias'=>'permission-update']);
        DB::table('permissions')->insert(['name'=>'Delete Permission','alias'=>'permission-delete']);

        DB::table('permissions')->insert(['name'=>'View Post List','alias'=>'post-viewAny']);
        DB::table('permissions')->insert(['name'=>'View Post Detail','alias'=>'post-view']);
        DB::table('permissions')->insert(['name'=>'Create Post','alias'=>'post-create']);
        DB::table('permissions')->insert(['name'=>'Edit Post','alias'=>'post-update']);
        DB::table('permissions')->insert(['name'=>'Delete Post','alias'=>'post-delete']);
    }
}
