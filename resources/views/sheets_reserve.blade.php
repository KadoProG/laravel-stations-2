@extends('layouts.layout')

@section('title', 'シート最終登録画面')

@section('content')





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


@if (isset($movie_id) && isset($schedule_id))

<form action="/reservations/store" method="POST" class="form">
  @csrf
  <h1>シート最終登録</h1>

  <div class="formTextField">
    <div>
      <p>ムービーID</p>
    </div>
    <div>
      <p>{{$movie_id}}</p>
    </div>
  </div>

  <div class="formTextField">
    <div>
      <p>スケジュールID</p>
    </div>
    <div>
      <p>{{ $schedule_id }}</p>
    </div>
  </div>
  <div class="formTextField">
    <div>
      <p>シートID</p>
    </div>
    <div>
      <p>{{ $sheet_id }}</p>
    </div>
  </div>

  <input type="hidden" name="movie_id" value="{{$movie_id}}">
  <input type="hidden" name="schedule_id" value="{{$schedule_id}}">
  <input type="hidden" name="sheet_id" value="{{$sheet_id}}">

  <div class="formTextField">
    <div>
      <p>日付</p>
    </div>
    <div>
      <p>{{ $date }}</p>
    </div>
  </div>

  <div class="formTextField fullWidth">
    <div>
      <p>お名前</p>
    </div>
    <div>
      <input type="text" name="name" required value="{{ old('name', '') }}" placeholder="映画　太郎">
      @error('name')
      <p style="color: red;">{{ $message }}</p>
      @enderror
    </div>
  </div>

  <div class="formTextField fullWidth">
    <div>
      <p>メールアドレス</p>
    </div>
    <div>
      <input type="email" name="email" required value="{{ old('email', '') }}" placeholder="example@gmail.com">
      @error('email')
      <p style="color: red;">{{ $message }}</p>
      @enderror
    </div>
  </div>

  <div style="display: flex; justify-content: center; padding: 10px">
    <button type="submit" class="linkButton">予約を確定する</button>
  </div>

</form>
@endif

@endsection