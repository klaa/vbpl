<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'published' => 1,
        'parent_id' => 0,
        'category_type' => $faker->randomElement(['post','product']),
        'ordering'  => $faker->randomDigit,
        'alias'     => $faker->unique()->slug,    
    ];
});
