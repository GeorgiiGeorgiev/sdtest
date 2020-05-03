<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id','text'];

    public function comments()
    {
    	return $this->hasMany('App\Comment');
    }
}
