<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment as Comment;
use App\Http\Resources\Comment as CommentResource;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        return CommentResource::collection(Comment::with('childs')->get());
    }

    public function show(Comment $comment)
    {
        return CommentResource($comment);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'text' => 'required|min:5',
            'post_id' => 'required|numeric',
        ]);

        if ($validator->fails()) return response()->json(['errors'=>$validator->errors()->all()]);

        $comment = new CommentResource(Comment::create($request->all()));

        return response()->json($comment, 201);
    }

    public function update(Request $request, Comment $comment)
    {
        $validator = \Validator::make($request->all(), [
            'text' => 'required|min:5',
            'post_id' => 'required|numeric',
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) return response()->json(['errors'=>$validator->errors()->all()]);

        $comment->update($request->all());

        return response()->json(new CommentResource($comment), 200);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(null, 204);
    }
}
