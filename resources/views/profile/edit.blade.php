@extends('layouts.app')

@section('head')
    <style>
        .article_thumbnail {
            margin-top: 10px;
            width: 50px;
            height: 50px;
            display: inline-block;
            border-radius: 0.25rem;
            background-size: cover;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @component('component.breadcrumb')
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                @endcomponent
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">Edit Profile</div>
                    <div class="card-body">
                        <div class="">
                            <img src="{{ asset('storage/profile/' . Auth::user()->photo) }}" class="w-100 rounded"
                                alt="">
                        </div>

                        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="" class="mt-3">Choose New Photo</label>
                                <input type="file" class="form-control" name="profile_photo" is-invalid>
                                @error('profile_photo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button class="btn btn-primary w-100">Update Profile Photo</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Change Password</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.change_password') }}">
                            @csrf

                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{ $error }}</p>
                            @endforeach

                            <div class="form-group">
                                <label for="password" class=" col-form-label text-md-right">Current Password</label>

                                <div class="">
                                    <input id="password" type="password" class="form-control" name="current_password"
                                        autocomplete="current-password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class=" col-form-label text-md-right">New Password</label>

                                <div class="">
                                    <input id="new_password" type="password" class="form-control" name="new_password"
                                        autocomplete="current-password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class=" col-form-label text-md-right">New Confirm
                                    Password</label>

                                <div class="">
                                    <input id="new_confirm_password" type="password" class="form-control"
                                        name="new_confirm_password" autocomplete="current-password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        Uploaded Photos
                    </div>
                    <div class="card-body">
                        @foreach (Auth::user()->getPhotos as $photo)
                            <div class="article_thumbnail"
                                style="background-image:url('{{ asset('storage/article/' . $photo->location) }}')">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
