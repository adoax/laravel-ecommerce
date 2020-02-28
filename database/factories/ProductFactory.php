<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->word(5),
        'slug' => $faker->unique()->slug,
        'excerpt' => $faker->sentence,
        'description' => $faker->text,
        'price' => $faker->numberBetween(15, 300) * 100,
        'image' => 'https://via.placeholder.com/200x250'
    ];
});
