@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @component('component.breadcrumb')
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Articles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Aricle Detail</li>
                @endcomponent
                <h4>Article Details</h4>
                <div class="card">
                    <div class="card-body">
                        @inject('users', 'App\User')
                        <div class="d-flex">
                            <p class="">{{ $users->find($article->user_id)->name }}</p>
                            <p class="">{{ $article->created_at->diffForHumans() }}</p>
                        </div>
                        <h4>{{ $article->title }}</h4>
                        <p>{{ $article->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
