<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(App\User::class, 3)->create()->each(function($u) {
            $u->questions()
              ->saveMany(
                  factory(App\Question::class, rand(1, 5))->make()
              );
        });

        //pass a anonymous function or callback into the each method, this means that each time a user is created, will create some fake questions for that user, we can define an argument in the callback to represent a single user, and get all questions for that user, since we want to create more than one questions, we can call saveMany and call another factory helper function in it,generate 1 to 5 questions for each user and call make method, not create since create() inserts records into database while make() generate objects and stored in memory
    }
}
