<?php

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class CustomKeyBugTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_neglects_custom_keys()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $post = factory(Post::class)->create([
            'user_id' => $user->id
        ]);

        $comment = factory(Comment::class)->create([
            'post_id' => $post->id
        ]);

        /*
         * Username passed for user model binding
         * ------> VALID FORMAT <------
         */
        $validUrl = route('custom-route', [
            'user' => $user->username,
            'post' => $post->id,
            'comment' => $comment->id
        ]);

        /*
         * User ID passed for user model binding
         * ------> INVALID FORMAT <------
         */
        $invalidUrl = route('custom-route', [
            'user' => $user->id,
            'post' => $post->id,
            'comment' => $comment->id
        ]);

        /*
         * A ModelNotFound exception is thrown
         * though the URL is DEFINITELY VALID
         */
        $this->get($validUrl);

        /*
         * No exception is thrown
         * though the URL is invalid
         */
        $this->expectException(ModelNotFoundException::class);
        $this->get($invalidUrl);
    }
}
