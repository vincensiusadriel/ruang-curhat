@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                @include('includes.messages')
                <a href="../.." class="btn btn-primary mb-3" style="background-color: #50b0dc; border-color: #50b0dc">Back</a>
                @if(count($friends) > 0)
                    @foreach($friends as $friend)
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex float-right">
                                    <form action="{{action('FriendController@update',[$friend->id])}}" method="POST" class="pr-3">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">
                                        <button type="submit" class="btn btn-primary">Accept</button>
                                    </form>
                                    <br>
                                    <form action="{{action('FriendController@destroy',[$friend->id])}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-secondary">Decline</button>
                                    </form>

                                </div>
                                <div class="wrapper">
                                    <div class="profile mr-3">
                                        <img src="/storage/avatar/{{$friend->profile_image}}" alt="" width="50rem" height="50rem">
                                    </div>
                                    <div class="contact">
                                        <p class="name" >
                                            <a href="/profile/{{$friend->id}}">
                                                {{$friend->name}}
                                            </a>

                                        </p>
                                        <p>{{$friend->status}}</p>


                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
