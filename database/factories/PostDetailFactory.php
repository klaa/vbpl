<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PostDetail;
use Faker\Generator as Faker;

$factory->define(PostDetail::class, function (Faker $faker) {
    return [
        'language'  => 'vn',
        'name'      => $faker->sentence,
        'alias'     => $faker->unique()->slug,
        'body'      => $faker->paragraph,
        'keywords'  => $faker->sentence,
        'desc'      => $faker->sentence,
        'title'     => $faker->sentence
    ];
});
