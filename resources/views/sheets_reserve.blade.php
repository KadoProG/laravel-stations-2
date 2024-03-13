@extends('layouts.layout')

@section('title', 'シート最終登録画面')

@section('content')

<form action="{{ $hasAdmin ? '/admin/reservations/' . ($reservation->id ?? '') : '/reservations/store' }}" method="POST" class="form">
  @csrf
  @if (isset($reservation))
  @method('PATCH') {{-- Use PATCH method for updates --}}
  @endif
  <h1>{{ isset($reservation) ? '予約編集' : 'シート最終登録' }}</h1>

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

  <div class="formTextField">
    <div>
      <p>ムービーID</p>
    </div>
    <div>
      @if ($hasAdmin)
      <input type="text" name="movie_id" required value="{{ old('movie_id', $reservation->schedule->movie_id ?? '') }}">
      @else
      <p>{{$movie_id ?? ''}}</p>
      @endif
      @error('movie_id')
      <p style="color: red;">{{ $message }}</p>
      @enderror
    </div>
  </div>

  <div class="formTextField">
    <div>
      <p>スケジュールID</p>
    </div>
    <div>
      @if ($hasAdmin)
      <input type="text" name="schedule_id" required value="{{ old('schedule_id', $reservation->schedule_id ?? '') }}">
      @else
      <p>{{$schedule_id ?? ''}}</p>
      @endif
      @error('schedule_id')
      <p style="color: red;">{{ $message }}</p>
      @enderror
    </div>
  </div>
  <div class="formTextField">
    <div>
      <p>シートID</p>
    </div>
    <div>
      @if ($hasAdmin)
      <input type="text" name="sheet_id" required value="{{ old('sheet_id', $reservation->sheet_id ?? '') }}">
      @else
      <p>{{$sheetId ?? ''}}</p>
      @endif
      @error('sheet_id')
      <p style="color: red;">{{ $message }}</p>
      @enderror
    </div>
  </div>


  <div class="formTextField">
    <div>
      <p>日付</p>
    </div>
    <div>
      @if ($hasAdmin)
      <input type="text" name="date" required value="{{ old('date', $reservation->date ?? '') }}">
      @else
      <p>{{$date ?? ''}}</p>
      @endif
      @error('date')
      <p style="color: red;">{{ $message }}</p>
      @enderror
    </div>
  </div>

  @if (!$hasAdmin)
  <input type="hidden" name="movie_id" value="{{ $movie_id }}">
  <input type="hidden" name="schedule_id" value="{{ $schedule_id }}">
  <input type="hidden" name="sheet_id" value="{{ $sheetId }}">
  <input type="hidden" name="date" value="{{ $date }}">
  @endif

  <div class="formTextField fullWidth">
    <div>
      <p>お名前</p>
    </div>
    <div>
      <input type="text" name="name" required value="{{ old('name', $reservation->name ?? '') }}" placeholder="映画　太郎">
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
      <input type="email" name="email" required value="{{ old('email', $reservation->email ?? '') }}" placeholder="example@gmail.com">
      @error('email')
      <p style="color: red;">{{ $message }}</p>
      @enderror
    </div>
  </div>

  <div style="display: flex; justify-content: center; padding: 10px">
    <button type="submit" class="linkButton">予約を確定する</button>
  </div>
</form>

@if ($hasAdmin && isset($reservation))
<form action="/admin/reservations/{{ $reservation->id }}" method="POST">
  @csrf
  @method('DELETE')
  <button type="submit" onclick="return confirm('本当に削除しますか？')">削除する</button>
</form>
@endif

@endsection