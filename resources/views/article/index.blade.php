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
                    <li class="breadcrumb-item active" aria-current="page">Aricle List</li>
                @endcomponent
                <div class="card">
                    <div class="card-header">Articles</div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="">
                                {{ $articles->links() }}
                            </div>

                            <div class="mb-3">
                                <form action="{{ route('article.index') }}" method="get">
                                    <div class="form-inline">
                                        <input type="text" name="search" class="form-control mr-3">
                                        <button class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @if (session('status'))
                            <p class="alert alert-danger">{!! session('status') !!}</p>
                        @endif
                        @if (session('update_status'))
                            <p class="alert alert-success">{!! session('update_status') !!}</p>
                        @endif
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Title</td>
                                    <td>Description</td>
                                    @if (Auth::user()->role == 0)
                                        <td>Owner</td>
                                    @endif
                                    <td>Control</td>
                                    <td>Created_at</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                    <tr>
                                        <td>{{ $article->id }}</td>
                                        <td>{{ substr($article->title, 0, 20) }}...</td>
                                        <td>{{ substr($article->description, 0, 50) }}...
                                            <br>
                                            @foreach ($article->getPhotos as $photo)
                                                <div class="article_thumbnail"
                                                    style="background-image:url('{{ asset('storage/article/' . $photo->location) }}')">
                                                </div>
                                            @endforeach
                                        </td>
                                        @if (Auth::user()->role == 0)
                                            <td class="text-nowrap">
                                                @isset($article->getUser)
                                                    {{ $article->getUser->name }}
                                                @else
                                                    Unknown
                                                @endisset
                                            </td>
                                        @endif
                                        <td class="text-nowrap">
                                            <a href="{{ route('article.show', $article->id) }}"
                                                class="btn btn-sm btn-primary">Detail</a>
                                            <a href="{{ route('article.edit', $article->id) }}"
                                                class="btn btn-sm btn-secondary">Edit</a>
                                            <button class="btn btn-sm btn-danger"
                                                form="del{{ $article->id }}">Delete</button>
                                            <form action="{{ route('article.destroy', $article->id) }}"
                                                id="del{{ $article->id }}" method="post">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </td>
                                        <td class="text-nowrap">
                                            <small>
                                                {{ $article->created_at->format('d-m-Y') }}<br>
                                                {{ $article->created_at->format('h:i a') }} <br>
                                                {{ $article->created_at->diffForHumans() }}
                                            </small>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
