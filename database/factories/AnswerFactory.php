<?php

use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraphs(rand(3, 7), true),
        //set true to convert the paragraphs into a single string
        'user_id' => App\User::pluck('id')->random(),
        'votes_count' => rand(0, 5),
    ];
});
