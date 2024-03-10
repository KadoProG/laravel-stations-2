@extends('layouts.layout')

@section('title', 'ムービー詳細画面')

@section('content')

<h2>{{$movie->id}} {{$movie->title}}</h2>
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

<div class="movies">
  <div>
    <div>
      <p>{{$movie->published_year}}年 {{$movie->is_showing ? "上映中": "上映予定"}} {{$movie->description}}</p>
      <p>登録日:{{$movie->created_at}}</p>
      <p>更新日:{{$movie->updated_at}}</p>

      @if($hasAdmin)
      <div>
        <a href="/admin/movies/{{ $movie->id }}/edit">編集する</a>
        <a href="/admin/movies/{{ $movie->id }}/schedules/create">予定を追加</a>
      </div>
      <form action="/admin/movies/{{$movie->id }}/destroy" method="POST">
        @csrf
        @method('DELETE') {{-- Use PATCH method for updates --}}
        <button type="submit" onclick="return confirm('本当に削除しますか？')">削除する</button>
      </form>
      @endif
    </div>
    <img src="{{$movie->image_url}}" alt="画像" width="300" height="200">
  </div>
  <div>

    <div>

      <h2>公開予定</h2>
      <ul style="padding-left: 20px">
        @foreach($schedules as $schedule)
        <li>
          <a href="/admin/schedules/{{$schedule->id}}">
            上映：
            {{ \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d H:i') }}
            〜
            {{ \Carbon\Carbon::parse($schedule->end_time)->format('Y-m-d H:i') }}
          </a>
          @if($hasAdmin)
          <div style="display: flex">
            <a href="/admin/schedules/{{$schedule->id}}/edit">編集する</a>
            <form action="/admin/schedules/{{$schedule->id }}/destroy" method="POST">
              @csrf
              @method('DELETE') {{-- Use PATCH method for updates --}}
              <button type="submit" onclick="return confirm('本当に削除しますか？')">削除する</button>
            </form>
          </div>
          @else
          <div>
            <a href="{{ route('sheets.select',
            [
              'movie_id' => $movie->id,
              'schedule_id' => $schedule->id, 
              'date' => \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d'),
            ] ) }}" class="linkButton">座席を予約する</a>
          </div>
          @endif
        </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>

@endsection