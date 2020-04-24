<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert(['name'=>'Super User','alias'=>'super-user']);
        DB::table('groups')->insert(['name'=>'Administrator','alias'=>'administrator']);
        DB::table('groups')->insert(['name'=>'Manager','alias'=>'manager']);
        DB::table('groups')->insert(['name'=>'Registered','alias'=>'registered']);
    }
}
