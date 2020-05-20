<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductDetail;
use Faker\Generator as Faker;

$factory->define(ProductDetail::class, function (Faker $faker) {
    return [
        'code' => $faker->bothify('##??#??##?##'),
        'varriant_name' => $faker->name,
        'price' => $faker->randomFloat(3,2),
        'base_price' => $faker->randomFloat(3,2),
        'quantity'=> $faker->randomNumber(3),
        'unit'  => $faker->randomElement(['chiếc','kg','cái','hộp']),
    ];
});
