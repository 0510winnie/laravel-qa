<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\QuestionPolicy;
use App\Question;
use App\Answer;
use App\Policies\AnswerPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Question::class => QuestionPolicy::class,
        Answer::class => AnswerPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        \Gate::define('update-question', function($user, $question) {
            return $user->id === $question->user_id;
        });
        \Gate::define('delete-question', function($user, $question) {
            return $user->id === $question->user_id;
        });
        //first argument is the user instance that represents the current signed-in user, second is the model instance that will authorize.
        //return a boolean either true or false
        //since the logics here are basically the same, for now we can use one gate
        //now we have our gates defined, we can use them in the questions controller and views
    }
}
