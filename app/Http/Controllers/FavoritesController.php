<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use Auth;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //make sure the current user is signed in
    }

    public function store(Question $question)
    {
        //make the current question favorited by the current user
        $question->favorites()->attach(auth()->id());

        if(request()->expectsJson()){
            return response()->json(null, 204);
        }
        //reload the page
        return back();
    }

    public function destroy(Question $question)
    {
        //typehint the question instance
        $question->favorites()->detach(auth()->id());

        if(request()->expectsJson()){
            return response()->json();
            //since we have nothing to return , we can set it to null, and return a status 204 which indicates the action was executed successfully but there is no content to return
        }
        return back();
    }
}
