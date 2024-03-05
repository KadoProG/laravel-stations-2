@extends('layouts.layout')

@section('title', 'スケジュールを作成・編集する')

@section('content')

<h1>スケジュールを作成・編集する</h1>

{{-- バリデーションエラーメッセージの表示 --}}
@if ($errors->any())
<div style="color: red;">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<!-- ＜Movie（編集不可）データ -->
<h2>タイトル：{{$movie->title}}</h2>
<p>作品ID：{{$movie->id}}</p>
<p>画像URL：{{$movie->image_url}}</p>
<p>公開年：{{$movie->published_year}}</p>
<p>上映中・上映予定：{{$movie->is_showing == "1" ? '上映中': '上映予定'}}</p>
<p>概要：{{$movie->description}}</p>

<form action="/admin{{ isset($schedule) ? $schedule->id . '/schedules/update/':'movies/{$movie->id}/schedules/store' }}" method="POST">
  @csrf

  @if (isset($movie))
  @method('PATCH') {{-- Use PATCH method for updates --}}
  @endif

  <p>開始日時</p>
  <input type="date" name="start_time_date" required value="{{ old('start_time_date', $movie->start_time_date ?? '') }}">
  {{-- エラーメッセージの表示 --}}
  @error('start_time_date')
  <p style="color: red;">{{ $message }}</p>
  @enderror
  <input type="time" name="start_time_time" required value="{{ old('start_time_time', $movie->start_time_time ?? '') }}">
  {{-- エラーメッセージの表示 --}}
  @error('start_time_time')
  <p style="color: red;">{{ $message }}</p>
  @enderror
  <p>終了日時</p>
  <input type="date" name="end_time_date" required value="{{ old('end_time_date', $movie->end_time_date ?? '') }}">
  {{-- エラーメッセージの表示 --}}
  @error('end_time_date')
  <p style="color: red;">{{ $message }}</p>
  @enderror
  <input type="time" name="end_time_time" required value="{{ old('end_time_time', $movie->end_time_time ?? '') }}">
  {{-- エラーメッセージの表示 --}}
  @error('end_time_time')
  <p style="color: red;">{{ $message }}</p>
  @enderror

  <button type="submit">送信する</button>
</form>
</body>

</html>

@endsection