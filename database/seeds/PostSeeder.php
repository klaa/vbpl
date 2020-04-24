<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Post::class,100)->create()->each(function($item) {
            $item->post_details()->save(factory(App\PostDetail::class)->make());
        });
    }
}
