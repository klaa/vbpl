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
        DB::table('permissions')->insert(['name'=>'View Dashboard','alias'=>'view-dashboard','type'=>'dashboard']);
        
        DB::table('permissions')->insert(['name'=>'View User List','alias'=>'user-viewAny','type'=>'user']);
        DB::table('permissions')->insert(['name'=>'View User Detail','alias'=>'user-view','type'=>'user']);
        DB::table('permissions')->insert(['name'=>'Create User','alias'=>'user-create','type'=>'user']);
        DB::table('permissions')->insert(['name'=>'Edit User','alias'=>'user-update','type'=>'user']);
        DB::table('permissions')->insert(['name'=>'Delete User','alias'=>'user-delete','type'=>'user']);
        
        DB::table('permissions')->insert(['name'=>'View Group List','alias'=>'group-viewAny','type'=>'group']);
        DB::table('permissions')->insert(['name'=>'View Group Detail','alias'=>'group-view','type'=>'group']);
        DB::table('permissions')->insert(['name'=>'Create Group','alias'=>'group-create','type'=>'group']);
        DB::table('permissions')->insert(['name'=>'Edit Group','alias'=>'group-update','type'=>'group']);
        DB::table('permissions')->insert(['name'=>'Delete Group','alias'=>'group-delete','type'=>'group']);
        DB::table('permissions')->insert(['name'=>'Assign Group','alias'=>'group-assign','type'=>'group']);

        DB::table('permissions')->insert(['name'=>'View Permission List','alias'=>'permission-viewAny','type'=>'permission']);
        DB::table('permissions')->insert(['name'=>'View Permission Detail','alias'=>'permission-view','type'=>'permission']);
        DB::table('permissions')->insert(['name'=>'Create Permission','alias'=>'permission-create','type'=>'permission']);
        DB::table('permissions')->insert(['name'=>'Edit Permission','alias'=>'permission-update','type'=>'permission']);
        DB::table('permissions')->insert(['name'=>'Delete Permission','alias'=>'permission-delete','type'=>'permission']);

        DB::table('permissions')->insert(['name'=>'View Post List','alias'=>'post-viewAny','type'=>'post']);
        DB::table('permissions')->insert(['name'=>'View Post Detail','alias'=>'post-view','type'=>'post']);
        DB::table('permissions')->insert(['name'=>'Create Post','alias'=>'post-create','type'=>'post']);
        DB::table('permissions')->insert(['name'=>'Edit Post','alias'=>'post-update','type'=>'post']);
        DB::table('permissions')->insert(['name'=>'Delete Post','alias'=>'post-delete','type'=>'post']);

        DB::table('permissions')->insert(['name'=>'View Category List','alias'=>'category-viewAny','type'=>'category']);
        DB::table('permissions')->insert(['name'=>'View Category Detail','alias'=>'category-view','type'=>'category']);
        DB::table('permissions')->insert(['name'=>'Create Category','alias'=>'category-create','type'=>'category']);
        DB::table('permissions')->insert(['name'=>'Edit Category','alias'=>'category-update','type'=>'category']);
        DB::table('permissions')->insert(['name'=>'Delete Category','alias'=>'category-delete','type'=>'category']);
    }
}
