@extends('layouts.layout')

@section('title', 'ムービーソロ')

@section('content')

<h1>ムービーソロ</h1>
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
  <li>
    <p>{{ $movie->id }} :タイトル: {{ $movie->title }}</p>
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
    <p>公開予定</p>
    <ul>
      @foreach($schedules as $schedule)
      <li>
        上映開始：{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
        終了：{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
      </li>
      @endforeach
    </ul>
  </li>
</ul>

@endsection