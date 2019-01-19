<?php

use Faker\Generator as Faker;
use App\Question;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title' => rtrim($faker->sentence(5, 10),'.'), //remove the . at the end
        'body' => $faker->paragraphs(rand(3, 7), true), //this convert it into string instead of inside an array
        'views' => rand(0, 10),
        // 'answers_count' => rand(0, 10),
        // 'votes_count' => rand(-3, 10),
    ];
});
