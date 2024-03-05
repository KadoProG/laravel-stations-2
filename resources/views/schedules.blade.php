@extends('layouts.layout')

@section('title', 'スケジュール一覧')

@section('content')

@if($hasAdmin)
<a href="/admin/movies/create">新規作成</a>
@endif

<h1>スケジュール一覧</h1>

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

@foreach ($moviesWithSchedules as $movie)
<h2>{{ $movie->title }}</h2>
<ul>
  @foreach ($movie->schedules as $schedule)
  <li>
    <a href="/admin/schedules/{{$schedule->id}}">
      {{ $schedule->start_time }} - {{ $schedule->end_time }}
    </a>
  </li>
  @endforeach
</ul>
@endforeach


@endsection