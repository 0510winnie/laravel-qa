<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {

        /*
        $request->validate([
            'body' => 'required'
        ]);

        $question->answers()->create([
            'body' => $request->body,
            'user_id' => Auth::id()
        ]);
        */

        //simplified version, since from version 5.4, validate method returns an array of data that has been validated, which means passed the validation rules

        $question->answers()->create($request->validate([
            'body' => 'required'
        ]) + ['user_id' => \Auth::id()]);
        //merge these two with + operator

        return back()->with('success', 'Your answer has been submitted successfully');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question,Answer $answer)
    {
       $this->authorize('update', $answer);

       return view('answers.edit', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);
        //make sure the current user is authorized to do so

        $answer->update($request->validate([
            'body' => 'required'
        ]));

        if ($request->expectsJson()){
            return response()->json([
                'message' => 'success', 'Your answer has been updated',
                'body_html' => $answer->body_html
            ]);
        }

        return redirect()->route('questions.show', $question->slug)->with('success', 'Your answer has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        //although $question instance is useless in this method, the reason we defined it is to follow the routes we defined, there are two route parameters

        $this->authorize('delete', $answer);
        //authorize user

        $answer->delete();


        if (request()->expectsJson()){
            return response()->json([
                'message' => 'Your answer has been removed'
            ]);
        }

        return back()->with('success', 'Your answer has been removed');
    }
}
