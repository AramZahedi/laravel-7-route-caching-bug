<?php

namespace App;

class Comment extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'post_id'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
