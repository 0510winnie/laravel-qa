<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;

class AcceptAnswerController extends Controller
{
    //should define our function name as __invoke since that's the name Laravel expects for single action controller and typehint to answer
    public function __invoke(Answer $answer)
    {
        $this->authorize('accept', $answer);

        $answer->question->acceptBestAnswer($answer);
        //pass in the answer instance

        if(request()->expectsJson())
        {
            return response()->json([
                'message' => 'You have accepted this answer as best answer'
            ]);
        }
        return back();
    }
}
