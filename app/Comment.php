<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
    	'user_id',
    	'post_id',
    	'comment_id',
    	'text',
    	'nesting_level'
    ];

    protected $attributes = [
        'nesting_level' => 1,
        'user_id' => 1,
    ];

    public function post()
    {
    	return $this->belongsTo('App\Post');
    }

    public function childs()
    {
    	return $this->hasMany('App\Comment','comment_id');
    }

    public function parent()
    {
    	return $this->belongsTo('App\Comment','comment_id');
    }
}
