<?php

use Illuminate\Database\Seeder;
use App\Post as Post;
use App\Comment as Comment;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class,3)->create()->each(function ($post) {
            $commentsCount = rand(2,4);

            $comments = factory(Comment::class,$commentsCount)->make(['post_id' => $post->id,'nesting_level' => 1]);

            $post->comments()->saveMany($comments);

            foreach ($comments as $comment) {
                $this->generateChildComments($comment,5);
            }
        });
    }

    /**
     * [childComments description]
     * @param  App\Comment $comment
     * @param  int $maxLevel
     * @param  int $level
     * @return void
     */
    private function generateChildComments(Comment $comment,int $maxLevel,int $level = 1)
    {
        $commentsCount = rand(0,2);
        if ($commentsCount) {
            $childComments = factory(Comment::class,$commentsCount)->make([
                'post_id' => $comment->post_id,
                'nesting_level' => $comment->nesting_level + 1,
            ]);

            $comment->childs()->saveMany($childComments);

            if ($comment->nesting_level < ($maxLevel - 1)) {
                $nextLevel = $comment->nesting_level + 1;
                foreach ($childComments as $childComment) {
                    $this->generateChildComments($childComment,$maxLevel,$nextLevel);
                }
            }
        }
    }
}
