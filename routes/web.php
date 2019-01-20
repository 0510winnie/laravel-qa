<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions', 'QuestionsController')->except('show');

/* Route::post('/questions/{question}/answers', 'AnswersController@store')->name('answers.store');
*/

// or utilize nested route like this
Route::resource('questions.answers', 'AnswersController')->except(['index', 'create', 'show']);

Route::get('questions/{slug}', 'QuestionsController@show')->name('questions.show');

Route::post('answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');
//ideally, we need to specify a method here, but for now, let's use single action controller.
//Single actions controller is a controller that only handles a single action, and because we only have a single action in the controller, here we don't need to specify the action name

Route::post('/questions/{question}/favorites', 'FavoritesController@store')->name('questions.favorite');
Route::delete('/questions/{question}/favorites', 'FavoritesController@destroy')->name('questions.unfavorite');

Route::post('/questions/{question}/vote', 'VoteQuestionController');
Route::post('/answers/{answer}/vote', 'VoteAnswerController');

