<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'contact_id',
        'date_time',
        'user_id',
        'body',
    ];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}