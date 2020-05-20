<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CategoryDetail;
use Faker\Generator as Faker;

$factory->define(CategoryDetail::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'language' => 'vn',
        'desc'  => $faker->paragraph(),
        'keywords' => $faker->sentence,
        'title' => $faker->sentence
    ];
});
