<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;
use App\User;

class Answer extends Model
{
    protected $fillable = ['body', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    public static function boot()
    {
        //firstly, call the parent boot method
        parent::boot();

        //execute some code when a answer model instance is created
        static::created(function($answer) {
            $answer->question->increment('answers_count');
        });

        //this method receives a closure as an argument, in the closure, we can specify an argument to represent the current model instance

        static::deleted(function($answer) {
            $answer->question->decrement('answers_count');
        });
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        return $this->isBest() ? 'vote-accepted' :  '';
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function isBest()
    {
        return $this->id === $this->question->best_answer_id;
    }

    public function votes()
    {
        //define the reverse relationship
        return $this->morphToMany(User::class, 'votable');
    }
}
