<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'text' => 'required|max:1000'
        ]);

        $comment = new Comment();
        $comment->text = $request->text;
        $comment->made_by = auth()->user()->id;
        $comment->postId = $id;
        $comment->save();

        return redirect('/post/'.$id)->with('success','Curhat Terposting');
    }


    public function destroy($id, $postId)
    {
        $comment = Comment::find($id);

        if(auth()->user()->id !== $comment->made_by){
            return redirect('/');
        }

        $comment->delete();
        return redirect('/post/'.$postId)->with('success','Comment telah dihapus');
    }
}
