<?php

namespace App\Http\Controllers;

use App\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $friends = Auth::user()->friendsBis()->where('accepted',false)->get();
        return view('friendList')->with('friends',$friends);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id1)
    {
        $friend = new Friend();
        $friend->user1 = auth()->id();
        $friend->user2 = $id1;
        $friend->save();

        return redirect('/')->with('success','Friend has been added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $friend = Friend::where('user1',$id)->where('user2',auth()->id())->first();
        $friend->accepted = true;
        $friend->save();

        return redirect('')->with('success','Request accepted');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $friend = Friend::where(function ($q) use ($id){
            $q->where('user1', auth()->id());
            $q->where('user2', $id);
        })->orWhere(function ($q) use ($id){
            $q->where('user2', auth()->id());
            $q->where('user1', $id);
        })->first();

        $friend->delete();
        return redirect('/')->with('success','Successfully remove contact');
    }
}
