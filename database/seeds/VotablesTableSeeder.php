<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;
use App\Answer;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('votables')->delete();

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

        foreach(Answer::all() as $answer)
        {
            for ($i = 0; $i < rand(1, $numberOfUsers); $i++)
            {
                //get a random user
                $user = $users[$i];

                $user->voteAnswer($answer, $votes[rand(0,1)]);

            }
        }
    }
}
