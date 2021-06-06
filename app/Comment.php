<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //

    public function post(){
        return $this->belongsTo(Post::class, 'postId', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'made_by', 'id');
    }
}
