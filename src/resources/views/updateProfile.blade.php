@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                @include('includes.messages')
                <a href="../.." class="btn btn-primary mb-3" style="background-color: #50b0dc; border-color: #50b0dc">Back</a>
                <div class="row justify-content-center">
                    <h1>Profile Update</h1>
                </div>
                <br>
                <form action="{{action('ContactsController@updateProfile')}}" method="post" enctype="multipart/form-data">
                    <div class="mb-5 wrapper">
                        <div class="profile" style="flex-direction: column">
                            <img src="/storage/avatar/{{$profile->profile_image}}" style="border-radius: 50%; width: 15rem; height: 15rem;">
                            <input type="file" name="profile_image" id="" class="mt-5">
                        </div>
                        <div class="contact mt-5">

                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$profile->name}}" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                                    <div class="col-md-6">
                                        <input id="status" type="text" class="form-control @error('status') is-invalid @enderror" name="status" value="{{$profile->status}}" required autocomplete="status" autofocus>

                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label text-md-right"></label>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary" style="background-color: #50b0dc; border-color: #50b0dc">Update</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
