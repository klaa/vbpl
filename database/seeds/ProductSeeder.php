<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Product::class,100)->create()->each(function($item) {
        //     $item->post_details()->save(factory(App\PostDetail::class)->make());
        //     $item->product_details()->saveMany([factory(App\ProductDetail::class)->make(),factory(App\ProductDetail::class)->make(),factory(App\ProductDetail::class)->make()]);
        // });
    }
}
