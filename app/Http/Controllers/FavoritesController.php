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

        //reload the page
        return back();
    }

    public function destroy(Question $question)
    {
        //typehint the question instance
        $question->favorites()->detach(auth()->id());

        return back();
    }
}
