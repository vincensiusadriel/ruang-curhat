<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //

    public function user(){
        return $this->belongsTo(User::class, 'made_by', 'id');
    }

    public function comment(){
        return $this->hasMany(Comment::class, 'postId');
    }
}
