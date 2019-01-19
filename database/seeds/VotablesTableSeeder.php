<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //make sure only delete the records for questions
        \DB::table('votables')->where('votable_type', 'App\Question')->delete();

        //not pluck method since we need user instance in this case
        $users = User::all();
        $numberOfUsers = $users->count();
        $votes = [-1, 1]; //votes[1] for vote up

        foreach(Question::all() as $question)
        {
            for ($i = 0; $i < rand(1, $numberOfUsers); $i++)
            {
                //get a random user
                $user = $users[$i];

                $user->voteQuestion($question, $votes[rand(0,1)]);

            }
        }
    }
}
