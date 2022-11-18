@extends('layouts.app')
@section('head')
    <style>
        .article_thumbnail {
            margin-top: 10px;
            width: 100px;
            height: 100px;
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
                    <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Articles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Aricle</li>
                @endcomponent
                <div class="card">
                    <div class="card-header">Update article</div>
                    <div class="card-body">
                        @if (session('status'))
                            <p class="alert alert-success">{!! session('status') !!}</p>
                        @endif
                        <form action="{{ route('article.update', $article->id) }}" id="editForm" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="title">Update Article</label>
                                <input type="text" id="title" name="title"
                                    class="form-control @error('title') is-invalid @enderror" value="{{ $article->title }}">
                                @error('title')
                                    <small class="font-weight-bold text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Article description</label>
                                <textarea type="text" id="description" name="description" row="10"
                                    class="form-control @error('description') is-invalid @enderror">{{ $article->description }}</textarea>
                                @error('description')
                                    <small class="font-weight-bold text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button class="btn btn-primary" for="editForm">Update</button>

                        </form>
                        <hr>
                        @foreach ($article->getPhotos as $photo)
                            <div class="d-inline-block">
                                <div class="article_thumbnail"
                                    style="background-image:url('{{ asset('storage/article/' . $photo->location) }}')">
                                </div>
                                <form action="{{ route('photo.destroy', $photo->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn-danger btn-sm btn"
                                        style="margin-top:-60px;margin-left:20px">Delete</button>
                                </form>
                            </div>
                        @endforeach
                        <form action="{{ route('photo.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <div class="form-row">
                                <div class="col-12 col-md-6">
                                    <input type="file" id="photo" name="photo[]" multiple required
                                        class="form-control p-1 @error('photo.*') is-invalid @enderror"
                                        value="{{ old('photo[]') }}">
                                    @error('photo.*')
                                        <small class="font-weight-bold text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <button class="btn btn-primary">Upload new Photo</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
