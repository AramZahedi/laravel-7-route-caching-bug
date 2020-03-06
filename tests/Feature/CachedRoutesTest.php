<?php

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class Test extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_doesnt_return_needed_404_error_when_routes_are_cached()
    {
        $user = factory(User::class)->create();

        $post_1 = factory(Post::class)->create([
            'user_id' => $user->id
        ]);

        $post_2 = factory(Post::class)->create([
            'user_id' => $user->id
        ]);

        $comment_for_post_1 = factory(Comment::class)->create([
            'post_id' => $post_1->id
        ]);

        $comment_for_post_2 = factory(Comment::class)->create([
            'post_id' => $post_2->id
        ]);

        $validUrl = route('custom-route', [
            'user' => $user->username,
            'post' => $post_1->id,
            'comment' => $comment_for_post_1->id
        ]);

        $invalidUrl = route('custom-route', [
            'user' => $user->username,
            'post' => $post_1->id,
            'comment' => $comment_for_post_2->id
        ]);

        $this->get($validUrl)->assertStatus(200);
        $this->get($invalidUrl)->assertStatus(404);
    }
}
