@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                @include('includes.messages')
                <a href="../.." class="btn btn-primary mb-3" style="background-color: #50b0dc; border-color: #50b0dc">Back</a>
                <br>
                <div class="mb-5 wrapper">
                    <div class="profile mr-5">
                        <img src="/storage/avatar/{{$profile->profile_image}}" style="border-radius: 50%; width: 15rem; height: 15rem;">
                    </div>
                    <div class="contact mt-5">
                        <h1 style="font-weight: bold;">{{$profile->name}}</h1>
                        <h2 style="color: #4e555b">{{$profile->status}}</h2>
                        @if(!\Illuminate\Support\Facades\Auth::guest() && $profile->id == auth()->id())
                            <a href="/profile/{{auth()->id()}}/update" class="btn btn-primary mb-3" style="background-color: #50b0dc; border-color: #50b0dc; width: 10rem;">Update Profile</a>
                        @endif

                        @if(!\Illuminate\Support\Facades\Auth::guest() && $profile->id != auth()->id())
                            @if($friend == -1)
                                <button type="button" class="btn btn-primary" data-toggle="modal" style="width: 10rem;" data-target="#exampleModalCenter">
                                    Befriend
                                </button>

                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Do you wish to send request to {{ $profile->name}} ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <form action="{{action('FriendController@store',[$profile->id])}}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($friend == 1)
                                <button type="button" class="btn btn-secondary" data-toggle="modal" style="width: 10rem;" data-target="#exampleModalCenter">
                                    Unfriend
                                </button>

                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure to remove {{ $profile->name}} from your contact list ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <form action="{{action('FriendController@destroy',[$profile->id])}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($friend == 0)
                                <div class="card card-header">
                                    <h5>{{$profile->name}} has sent friend request, do you wish too...</h5>
                                    <div class="wrapper">
                                        <form action="{{action('FriendController@update',[$profile->id])}}" method="POST" class="pr-3">
                                            @csrf
                                            <input type="hidden" name="_method" value="PUT">
                                            <button type="submit" class="btn btn-primary">Accept</button>
                                        </form>
                                        <br>
                                        <form action="{{action('FriendController@destroy',[$profile->id])}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-secondary">Decline</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endif


                        <div class="wrapper mt-2">
                            <div class="mr-5 mb-2 profileitem" title="{{$profile->name}}'s likes received">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402m5.726-20.583c-2.203 0-4.446 1.042-5.726 3.238-1.285-2.206-3.522-3.248-5.719-3.248-3.183 0-6.281 2.187-6.281 6.191 0 4.661 5.571 9.429 12 15.809 6.43-6.38 12-11.148 12-15.809 0-4.011-3.095-6.181-6.274-6.181"/></svg>
                                {{$profile->posts->sum('likes')}}
                            </div>
                            <div class="mr-5 mb-2 profileitem" title="{{$profile->name}}'s posts">
                                @include('includes.pencilpaper')
                                {{$profile->posts->count()}}
                            </div>
                            <div class="mr-5 mb-2 profileitem" title="{{$profile->name}}'s comment given">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 1c-6.338 0-12 4.226-12 10.007 0 2.05.739 4.063 2.047 5.625l-1.993 6.368 6.946-3c1.705.439 3.334.641 4.864.641 7.174 0 12.136-4.439 12.136-9.634 0-5.812-5.701-10.007-12-10.007zm0 1c6.065 0 11 4.041 11 9.007 0 4.922-4.787 8.634-11.136 8.634-1.881 0-3.401-.299-4.946-.695l-5.258 2.271 1.505-4.808c-1.308-1.564-2.165-3.128-2.165-5.402 0-4.966 4.935-9.007 11-9.007zm-5 7.5c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5zm5 0c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5zm5 0c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5z"/></svg>
                                {{$profile->comment->count()}}
                            </div>
                        </div>


                    </div>


                </div>
                <hr class="mb-5">

                @if(!\Illuminate\Support\Facades\Auth::guest() && $profile->id == auth()->id())
                    <div class="card card-body mb-3">
                        <div class="wrapper">
                            <div class="profile">
                                <img src="/storage/avatar/{{auth()->user()->profile_image}}" alt="" width="50rem" height="50rem">
                            </div>
                            <div class="contact">
                                <p class="name">{{auth()->user()->name}}</p>
                                <p>{{auth()->user()->status}}</p>

                            </div>
                        </div>
                        <hr>
                        <form method="POST" action="{{action('PostController@store')}}">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control @error('text') is-invalid @enderror" name="text" id="" rows="3" placeholder="Aku mau bilang sesuatu..."></textarea>
                                @error('text')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary" style="background-color: #50b0dc; border-color: #50b0dc">Curahkan</button>
                        </form>
                    </div>
                @endif

                @if(count($posts) > 0)
                    {{$posts->links()}}
                    @foreach($posts as $post)
                        <div class="card mb-3" >
                            <div class="card-body">
                                <div class="d-flex float-right align-items-end flex-column">
                                    @if(!\Illuminate\Support\Facades\Auth::guest())
                                        @if(auth()->user()->id == $post->made_by)
                                            <div class="d-inline-block">
                                                <form action="{{action('PostController@destroy',[$post->id])}}" method="POST">
                                                    @csrf
                                                    <a href="/post/{{$post->id}}/edit" class="mr-2">@include('includes.pencil')</a>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="emptyButton">@include('includes.trashcan')</button>
                                                </form>
                                            </div>
                                        @endif
                                    @endif

                                    <div class="">
                                        <small class=""> @include('includes.time') {{$post->updated_at}}</small>
                                    </div>

                                </div>

                                <div class="wrapper">
                                    <div class="profile">
                                        <img src="/storage/avatar/{{$post->user['profile_image']}}" alt="" width="50rem" height="50rem">
                                    </div>
                                    <div class="contact">
                                        <p class="name" >
                                            <a href="/profile/{{$post->user['id']}}">
                                                {{$post->user['name']}}
                                            </a>
                                        </p>
                                        <p>{{$post->user['status']}}</p>

                                    </div>
                                </div>
                                <hr>
                                {{$post->text}}
                            </div>
                            <div class="card-header">
                                <div class="d-inline-flex mt-1">
                                    @if(!\Illuminate\Support\Facades\Auth::guest())
                                        <button onclick="actOnChirp(event);" data-chirp-id="{{ $post->id }}" class="btn btn-outline-primary mr-3" value="Like">Like</button>
                                    @endif
                                    <div class="mr-5 align-self-center">
                                        @include('includes.love')
                                        <span id="likes-count-{{ $post->id }}">{{ $post->likes }}</span>
                                    </div>
                                    <div class="mr-3 align-self-center">
                                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 1c-6.338 0-12 4.226-12 10.007 0 2.05.739 4.063 2.047 5.625l-1.993 6.368 6.946-3c1.705.439 3.334.641 4.864.641 7.174 0 12.136-4.439 12.136-9.634 0-5.812-5.701-10.007-12-10.007zm0 1c6.065 0 11 4.041 11 9.007 0 4.922-4.787 8.634-11.136 8.634-1.881 0-3.401-.299-4.946-.695l-5.258 2.271 1.505-4.808c-1.308-1.564-2.165-3.128-2.165-5.402 0-4.966 4.935-9.007 11-9.007zm-5 7.5c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5zm5 0c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5zm5 0c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5z"/></svg>
                                        {{$post->comment->count()}}
                                    </div>
                                </div>

                                <a class="btn btn-primary float-right" style="border-radius: 30px; width: 100px" href="/post/{{$post->id}}">Balas</a>

                            </div>
                        </div>

                    @endforeach
                    {{$posts->links()}}
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var updateChirpStats = {
            Like: function (chirpId) {
                document.querySelector('#likes-count-' + chirpId).textContent++;
            },

            Unlike: function(chirpId) {
                document.querySelector('#likes-count-' + chirpId).textContent--;
            }
        };


        var toggleButtonText = {
            Like: function(button) {
                button.textContent = "Unlike";
            },

            Unlike: function(button) {
                button.textContent = "Like";
            }
        };

        var actOnChirp = function (event) {
            var chirpId = event.target.dataset.chirpId;
            var action = event.target.textContent;
            toggleButtonText[action](event.target);
            updateChirpStats[action](chirpId);
            axios.post('/post/' + chirpId + '/act',
                { action: action });
        };

    </script>
@endsection

