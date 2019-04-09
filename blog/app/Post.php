<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'title', 'content', 'tags', 'user_id', 'created', 'updated'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
