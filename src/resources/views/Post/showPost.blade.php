@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                @include('includes.messages')
                <a href="/" class="btn btn-primary mb-3" style="background-color: #50b0dc; border-color: #50b0dc">Back</a>
                <div class="card mb-3" >
                    <div class="card-body">
                        <small class="float-right"> @include('includes.time') {{$post->updated_at}}</small>
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
                        <div style="display: inline-flex">
                            @if(!\Illuminate\Support\Facades\Auth::guest())
                                <button onclick="actOnChirp(event);" data-chirp-id="{{ $post->id }}" class="btn btn-outline-primary mr-3" value="Like">Like</button>
                            @endif
                            <div class="mr-5 align-self-center">
                                @include('includes.love')
                                <span id="likes-count-{{ $post->id }}">{{ $post->likes }}</span>
                            </div>
                            <div class="mr-3 align-self-center">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 1c-6.338 0-12 4.226-12 10.007 0 2.05.739 4.063 2.047 5.625l-1.993 6.368 6.946-3c1.705.439 3.334.641 4.864.641 7.174 0 12.136-4.439 12.136-9.634 0-5.812-5.701-10.007-12-10.007zm0 1c6.065 0 11 4.041 11 9.007 0 4.922-4.787 8.634-11.136 8.634-1.881 0-3.401-.299-4.946-.695l-5.258 2.271 1.505-4.808c-1.308-1.564-2.165-3.128-2.165-5.402 0-4.966 4.935-9.007 11-9.007zm-5 7.5c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5zm5 0c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5zm5 0c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5z"/></svg>
                                {{count($comments)}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-10 mt-3">
                <h1>Komentar</h1>
                @if(!\Illuminate\Support\Facades\Auth::guest())
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="wrapper">
                                <div class="profile mr-3">
                                    <img src="/storage/avatar/{{auth()->user()->profile_image}}" alt="" width="50rem" height="50rem">
                                </div>
                                <div class="contact">
                                    <p class="name">{{auth()->user()->name}}</p>
                                    <form method="POST" action="{{action('CommentController@store',$post->id)}}">
                                        @csrf
                                        <div class="form-group">
                                            <textarea class="form-control @error('text') is-invalid @enderror" name="text" id="" rows="3" placeholder="Menurutku..."></textarea>
                                            @error('text')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="background-color: #50b0dc; border-color: #50b0dc">Komentarkan</button>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                @endif
                @if(count($comments))
                    @foreach($comments as $comment)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex float-right align-items-end flex-column">
                                    @if(!\Illuminate\Support\Facades\Auth::guest())
                                        @if(auth()->user()->id == $comment->made_by)
                                            <div class="d-inline-block">
                                                <form action="{{action('CommentController@destroy',[$comment->id, $post->id])}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="emptyButton">@include('includes.trashcan')</button>
                                                </form>
                                            </div>
                                        @endif
                                    @endif

                                    <div class="">
                                        <small class=""> @include('includes.time') {{$comment->updated_at}}</small>
                                    </div>
                                </div>

                                <div class="wrapper">
                                    <div class="profile mr-3">
                                        <img src="/storage/avatar/{{$comment->user['profile_image']}}" alt="" width="50rem" height="50rem">
                                    </div>
                                    <div class="contact">
                                        <p class="name" >
                                            <a href="/profile/{{$comment->user['id']}}">
                                                {{$comment->user['name']}}
                                            </a>
                                        </p>
                                        <p>{{$comment->text}}</p>

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

