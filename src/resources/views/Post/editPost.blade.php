@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                @include('includes.messages')
                <a href="./" class="btn btn-primary mb-3" style="background-color: #50b0dc; border-color: #50b0dc">Back</a>

                @if(!\Illuminate\Support\Facades\Auth::guest())
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
                        <form method="POST" action="{{action('PostController@update',$post->id)}}">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control @error('text') is-invalid @enderror" name="text" id="" rows="3" value="">{{$post->text}}</textarea>
                                @error('text')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <input type="hidden" name="_method" value="PUT">
                            <button type="submit" class="btn btn-primary" style="background-color: #50b0dc; border-color: #50b0dc">Curahkan</button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
