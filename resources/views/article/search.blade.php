@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @component('component.breadcrumb')
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Articles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Aricle List</li>
                @endcomponent
                <div class="card">
                    <div class="card-header">Articles</div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="">
                                {{ $articles->appends(Request::all())->links() }}
                            </div>
                            <div class="mb-3">
                                <form action="{{ route('article.search') }}" method="post">
                                    @method('get')
                                    @csrf
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
                                    <td>Owner</td>
                                    <td>Control</td>
                                    <td>Created_at</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($articles) < 1)
                                    <tr>
                                        <td colspan="6" class="text-center">There is no result!</td>
                                    </tr>
                                @else
                                    @inject('users', 'App\User')
                                    @foreach ($articles as $article)
                                        <tr>
                                            <td>{{ $article->id }}</td>
                                            <td>{{ substr($article->title, 0, 20) }}...</td>
                                            <td>{{ substr($article->description, 0, 50) }}...</td>
                                            <td class="text-nowrap">{{ $users->find($article->user_id)->name }}</td>
                                            <td class="text-nowrap">
                                                <a href="{{ route('article.show', $article->id) }}"
                                                    class="btn btn-sm btn-primary">Detail</a>
                                                <a href="{{ route('article.edit', $article->id) }}"
                                                    class="btn btn-sm btn-secondary">Edit</a>
                                                <button class="btn btn-sm btn-danger" form="del">Delete</button>
                                                <form action="{{ route('article.destroy', $article->id) }}" id="del"
                                                    method="post">
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
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
