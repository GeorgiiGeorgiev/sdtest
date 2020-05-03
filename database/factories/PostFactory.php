<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post as Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
    return [
    	'user_id' => $faker->randomDigitNotNull(),
        'text' => $faker->text,
    ];
});