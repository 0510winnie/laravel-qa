<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class VoteQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Question $question)
    {
        $vote = (int) request()->vote; //capture the vote

        $votesCount = auth()->user()->voteQuestion($question, $vote);
        //auth helper method and call user method to get current user instance

        if (request()->expectsJson()) {
            return response()->json([
                'message' =>  'Thanks for the feedback',
                'votesCount' => $votesCount
            ]);
        }
        return back();
        //refresh the page
    }
}

