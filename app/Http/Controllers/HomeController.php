<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\User;

class HomeController extends Controller
{
    public function show(User $user, Post $post, Comment $comment)
    {
        return response([], 200);
    }
}
