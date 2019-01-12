<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value) {
        //we when do something to title attribute, it will do something
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);

    }

    public function getUrlAttribute()
    {
        //accessors start with get end with attribute
        return route('questions.show', $this->id);
        //pass in question id, since we are inside the question model, simple $this
    }

    public function getCreatedDateAttribute()
    {
        //we define accessors name in camelCase, but when we call it, call it in snake case like created_date
        return $this->created_at->diffForHumans();
    }
}
