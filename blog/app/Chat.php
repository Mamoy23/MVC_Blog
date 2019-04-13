<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'from_id',
        'to_id',
        'content',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
