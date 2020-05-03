<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment as Comment;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Comment::class, function (Faker $faker) {
    return [
    	'user_id' => $faker->randomDigitNotNull(),
        'text' => $faker->text,
    ];
});