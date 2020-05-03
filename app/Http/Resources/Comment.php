<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
            'nesting_level' => $this->nesting_level,
            'comment_id' => $this->comment_id,
            'post_id' => $this->post_id,
            'user_id' => $this->user_id,
            'childs' => self::collection($this->childs),
            'parent' => $this->parent,
            'reply' => ['text' => ''], // new CommentModel
            'created' => $this->created_at->format('d.m.Y H:i:s'),
            'updated' => $this->updated_at->format('d.m.Y H:i:s'),
        ];
    }
}
