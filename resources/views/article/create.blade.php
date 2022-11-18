@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @component('component.breadcrumb')
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Articles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Aricle</li>
                @endcomponent
                <div class="card">
                    <div class="card-header">Add article</div>
                    <div class="card-body">
                        @if (session('status'))
                            <p class="alert alert-success">{!! session('status') !!}</p>
                        @endif
                        <form action="{{ route('article.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Article Title</label>
                                <input type="text" id="title" name="title"
                                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                                @error('title')
                                    <small class="font-weight-bold text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-12 col-md-6">
                                        <label for="photo"> Upload Photo</label>
                                        <input type="file" id="photo" name="photo[]" multiple
                                            class="form-control p-1 @error('photo.*') is-invalid @enderror"
                                            value="{{ old('photo[]') }}">
                                        @error('photo.*')
                                            <small class="font-weight-bold text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Article description</label>
                                <textarea type="text" id="description" name="description" row="10"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="font-weight-bold text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button class="btn btn-primary">Save article</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
