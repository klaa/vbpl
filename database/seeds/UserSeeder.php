<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'      => 'Nguyễn Hữu Khánh',
            'username'  => 'nguyenkhanh87',
            'email'     => 'nguyenkhanh87@gmail.com',
            'password'  => Hash::make("!@#quanly#@!"),
        ]);

        DB::table('user_group')->insert([
            'user_id' => 1,
            'group_id' => 1,
        ]);
    }
}
