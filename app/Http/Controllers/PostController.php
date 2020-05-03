<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post as Post;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(
            Post::with([
                'comments' => function ($q) {
                    $q->where('nesting_level','=','1')->orderBy('created_at','desc');
                }
            ])->get()
        );

    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function store(Request $request)
    {
        $post = new PostResource(Post::create($request->all()));

        return response()->json($post, 201);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());

        return response()->json(new PostResource($post), 200);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(null, 204);
    }
}
