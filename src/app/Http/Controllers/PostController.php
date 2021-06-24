<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Friend;
use App\Message;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth', ['except'=>['index','show','profile']]);
    }

    public function index()
    {
        $request = \request()->search;
        $posts = Post::where('text','LIKE',"%$request%")->orWhereHas('user', function($q) use ($request){
            $q->where('name', 'LIKE',"%$request%");
        })->orderBy('created_at','desc')->paginate(10);
        $posts->appends(['search'=>$request]);
//        $comments = Comment::select(\DB::raw('`postId` as post_id, count(`postId`) as post_count'))
//            ->groupBy('postId')
//            ->get();
//
//        $posts = $posts->map(function ($post) use ($comments){
//            $postComment = $comments->where('post_id', $post->id)->first();
//            $post->comments = $postComment ? $postComment->post_count : 0;
//
//            return $post;
//        });



        return view('welcome')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'text' => 'required|max:1000'
        ]);

        $post = new Post();
        $post->text = $request->text;
        $post->made_by = auth()->user()->id;
        $post->save();

        return redirect('/')->with('success','Curhat Terposting');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $comments = Comment::where('postId',$id)->orderBy('updated_at','desc')->get();
        return view('Post.showPost')->with('post',$post)->with('comments',$comments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if(auth()->user()->id !== $post->made_by){
            return redirect('/');
        }

        return view('Post.editPost')->with('post',$post);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'text' => 'required|max:1000'
        ]);

        $post = Post::find($id);
        $post->text = $request->text;
        $post->made_by = auth()->user()->id;
        $post->save();

        return redirect('/')->with('success','Curhat Terbaharui');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if(auth()->user()->id !== $post->made_by){
            return redirect('/');
        }

        $post->delete();
        return redirect('/')->with('success','Post telah dihapus');
    }

    public function profile($id){
        $request = \request()->search;
        $posts = Post::where('made_by',$id)->where('text','LIKE',"%$request%")->orderBy('created_at','desc')->paginate(5);
        //$posts = Post::where('made_by',$id)->orderBy('created_at','desc')->get();
//        $comments = Comment::select(\DB::raw('`postId` as post_id, count(`postId`) as post_count'))
//            ->groupBy('postId')
//            ->get();
//
//        $posts = $posts->map(function ($post) use ($comments){
//            $postComment = $comments->where('post_id', $post->id)->first();
//            $post->comments = $postComment ? $postComment->post_count : 0;
//
//            return $post;
//        });

        $posts->appends(['search'=>$request]);

        $profile = User::find($id);
        $friend = Friend::select(\DB::raw('accepted'))->where(function ($q) use ($id){
            $q->where('user1', auth()->id());
            $q->where('user2', $id);
        })->orWhere(function ($q) use ($id){
            $q->where('user2', auth()->id());
            $q->where('user1', $id);
        })->get();


        $friend = (count($friend) > 0) ? (int)$friend->first()->accepted : -1;





        return view('profile')->with('posts',$posts)->with('profile',$profile)->with('friend',$friend);
    }

    public function actOnChirp(Request $request, $id)
    {
        $action = $request->get('action');
        switch ($action) {
            case 'Like':
                Post::where('id', $id)->increment('likes');
                break;
            case 'Unlike':
                Post::where('id', $id)->decrement('likes');
                break;
        }
        return '';
    }
}
