<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillablel = [
        'username'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }
}
