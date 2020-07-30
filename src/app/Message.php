<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'contact_id',
        'created_at',
        'updated_at',
        'user_id',
        'title',
        'body',
    ];
}
