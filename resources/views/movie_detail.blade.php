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
    <div>
      <a href="/admin/movies/{{ $movie->id }}/edit">編集する</a>
      <a href="/admin/movies/{{ $movie->id }}/schedules/create">予定を追加</a>
    </div>

    <form action="/admin/movies/{{$movie->id }}/destroy" method="POST">
      @csrf
      @method('DELETE') {{-- Use PATCH method for updates --}}
      <button type="submit" onclick="return confirm('本当に削除しますか？')">削除する</button>
    </form>
    <h2>公開予定</h2>
    <ul>
      @foreach($schedules as $schedule)
      <li>
        <a href="/admin/schedules/{{$schedule->id}}">
          上映：{{ $schedule->start_time }}〜{{ $schedule->end_time }}
        </a>
        <a href="/admin/schedules/{{$schedule->id}}/edit">編集する</a>
        <form action="/admin/schedules/{{$schedule->id }}/destroy" method="POST">
          @csrf
          @method('DELETE') {{-- Use PATCH method for updates --}}
          <button type="submit" onclick="return confirm('本当に削除しますか？')">削除する</button>
        </form>
      </li>
      @endforeach
    </ul>
  </li>
</ul>

@endsection