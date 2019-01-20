<?php

namespace App;
use App\User;
use App\Answer;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use VotableTrait;

    protected $fillable = ['title', 'body'];

    protected $appends = ['created_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value) {
        //we when do something to title attribute, it will do something
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);

    }

    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                //if best_answer_id is not null
                return 'answered-accepted';
            }
            return 'answered' ;
        } else {
            return 'unanswered';
        }
    }

    public function getUrlAttribute()
    {
        //accessors start with get end with attribute
        return route('questions.show', $this->slug);
        //pass in question id, since we are inside the question model, simple $this
    }

    public function getCreatedDateAttribute()
    {
        //we define accessors name in camelCase, but when we call it, call it in snake case like created_date
        return $this->created_at->diffForHumans();
    }

    public function getBodyHtmlAttribute()
    {
        return clean($this->bodyHtml());
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    public function excerpt($length)
    {
        return str_limit(strip_tags($this->bodyHtml()), $length);
    }

    private function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }

}
