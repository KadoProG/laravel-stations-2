@extends('layouts.layout')

@section('title', 'ムービー一覧')

@section('content')

@if($hasAdmin)
<a href="/admin/movies/create">新規作成</a>
@endif

<h1>ムービー一覧</h1>

<p>検索リスト</p>
<p>is_showing: {{ isset($is_showing) ? $is_showing : '何も設定されていません' }}</p>
<p>keyword: {{ isset($keyword) ? $keyword : '何も設定されていません' }}</p>

@if (session('error'))
<p style="color: red">
  {{ session('error') }}
</p>
@endif
@if (session('success'))
<p style="color: green">
  {{ session('success') }}
</p>
@endif

<ul class="movies">
  @if (count($movies) === 0)
  <li>ブログはありません</li>
  @endif
  @foreach ($movies as $movie)
  <li>
    <p>{{ $movie->id }} :タイトル: {{ $movie->title }}</p>
    <a href="/{{ $hasAdmin ? 'admin/': ''}}movies/{{ $movie->id }}">詳細を確認する</a>
    <ul>
      <li>公開年:{{$movie->published_year}}</li>
      <li>現　在:{{$movie->is_showing ? "上映中": "上映予定"}}</li>
      <li>説　明:{{$movie->description}}</li>
      <li>登録日:{{$movie->created_at}}</li>
      <li>更新日:{{$movie->updated_at}}</li>
    </ul>
    <img src="{{$movie->image_url}}" alt="画像" width="300" height="200">
    <a href="/admin/movies/{{ $movie->id }}/edit">編集する</a>
    <form action="/admin/movies/{{$movie->id }}/destroy" method="POST">
      @csrf
      @method('DELETE') {{-- Use PATCH method for updates --}}
      <button type="submit" onclick="return confirm('本当に削除しますか？')">削除する</button>
    </form>
  </li>
  @endforeach
</ul>
{{ $movies->appends(['keyword' => Request::input('keyword'), 'is_showing' => Request::input('is_showing')])->links() }}

@endsection