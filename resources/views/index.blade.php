@extends('layouts.app')

@section('content')
    <h1 class="mb-4">映画一覧</h1>
    <div class="row">
        @foreach ($movies as $movie)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img class="card-img-top" src="{{ $movie->image_url }}" alt="{{ $movie->title }}">
                    <div class="card-body">
                        <p class="card-text mb-0">{{ $movie->title }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
