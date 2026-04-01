@extends('layouts.app')

@section('content')

@if (session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif

<h1 class="mb-4">映画一覧（管理画面）</h1>
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">画像</th>
      <th scope="col">タイトル</th>
      <th scope="col">概要</th>
      <th scope="col">公開年</th>
      <th scope="col">上映中かどうか</th>
      <th scope="col">アクション</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($movies as $movie)
    <tr>
      <td>{{ $movie->id }}</td>
      <td><img src="{{ $movie->image_url }}" alt="{{ $movie->title }}" style="width: 100px; height: auto;"></td>
      <td>{{ $movie->title }}</td>
      <td>{{ $movie->description }}</td>
      <td>{{ $movie->published_year }}</td>
      <td>{{ $movie->is_showing ? '上映中' : '上映予定' }}</td>
      <td>
        <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-primary">編集</a>
        <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="post" class="d-inline" onsubmit="return confirm('この映画を削除しますか？');">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">削除</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection