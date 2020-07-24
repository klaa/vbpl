<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'category_id' => $faker->numberBetween(1,11),
        'user_id' => $faker->numberBetween(1,100),
        'is_featured' => $faker->randomElement([0,1]),
        'ordering' => $faker->randomDigit,
        'post_type' => 'post',
        'name'      => $faker->sentence,
        'body'      => $faker->paragraph,
        'alias'     => $faker->unique()->slug,
        'vanban'    => $faker->randomElement(['documents/505.pdf','documents/505.docx']),
        'kyhieu'    => $faker->bothify('###-??-?##??'),
        'trangthai' => $faker->randomElement([0,1,2]),
        'ngaybanhanh'=>$faker->date(),
        'hieulucvb' => $faker->date(),
        'post_type_2' => $faker->randomElement(['vbnn','vbt'])
    ];
});
