<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Comment as Comment;

class CommentTest extends TestCase
{
    public function testsCreate()
    {
       $data = [
            'post_id' => $this->faker->randomDigitNotNull(),
            'text' => $this->faker->text,
        ];

        $this->json('POST', '/api/comments', $data)
            ->assertStatus(201)
            ->assertJson(['post_id' => $data['post_id'], 'text' => $data['text']])
            ->assertJsonStructure([
                'id','user_id','post_id','text',
                'comment_id','nesting_level','childs',
                'parent','reply','created','updated'
            ]);
    }

    public function testsUpdate()
    {
        $comment = factory(Comment::class)->create([
            'text' => 'Lorem',
            'post_id' => 1,
            'user_id' => 1,
        ]);

        $data = [
            'text' => 'Ipsum',
            'post_id' => 2,
            'id' => $comment->id,
        ];

        $response = $this->json('PUT', '/api/comments/' . $comment->id, $data)
            ->assertStatus(200)
            ->assertJson(['id' => $comment->id,'text' => 'Ipsum','post_id' => 2])
            ->assertJsonStructure([
                'id','user_id','post_id','text',
                'comment_id','nesting_level','childs',
                'parent','reply','created','updated'
            ]);
    }

    public function testsDelete()
    {
        $comment = factory(Comment::class)->create([
            'text' => 'Lorem',
            'post_id' => 1,
        ]);

        $this->json('DELETE', '/api/comments/' . $comment->id, [])
            ->assertStatus(204);
    }

    public function testList()
    {
        $response = $this->json('GET', '/api/comments')
            ->assertStatus(200)
            ->assertJson(['data' => array()]);
            //->assertJsonStructure([
                //'*' => [
                    //'id',
                    //'user_id',
                    //'post_id',
                    //'text',
                    //'comment_id',
                    //'childs',
                    //'parent',
                    //'reply',
                    //'created',
                    //'updated',
                //]
            //]);

    }
}
