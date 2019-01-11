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
}
