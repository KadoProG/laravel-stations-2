@extends('layouts.layout')

@section('title', 'シート最終登録画面')

@section('content')


<h1>シート最終登録</h1>


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


<style>
  table tr th {
    width: 80px;
    background: #ddd;
  }

  table tr td {
    background: #f5f5f5;
    text-align: center;
  }

  table tr td button {
    width: 100%;
    background: transparent;
    border: none;
    height: 24px;
    cursor: pointer;
    margin-bottom: 2px;
  }

  table tr td button:hover {
    background: #fff;
  }
</style>

@if (isset($movie_id) && isset($schedule_id))
<p>ムービーID: {{$movie_id}}</p>
<p>スケジュールID: {{$schedule_id}}</p>
<p>スケジュールID: {{$sheet_id}}</p>
@endif

@endsection