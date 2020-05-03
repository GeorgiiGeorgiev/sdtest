<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Comment as CommentResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => htmlspecialchars($this->text),
            'userId' => $this->user_id,
            'comments' => CommentResource::collection($this->comments),
            'created' => $this->created_at->format('d.m.Y H:i:s'),
            'updated' => $this->updated_at->format('d.m.Y H:i:s'),
        ];
    }
}
