@extends('layouts.layout')

@section('title', '予約一覧画面')

@section('content')

<style>
  table thead tr td {
    padding: 10px;
    background: #ddd;
  }

  table tbody tr td {
    padding: 10px;
    background: #f5f5f5;
  }
</style>

<div style="display: flex;flex-flow:column; margin: 0 auto; max-width: 1200px">
  <div style="display: inline-flex; justify-content: space-between; padding: 4px">
    <h1>予約一覧</h1>
    @if($hasAdmin)
    <a href="/admin/reservations/create" class="linkButton">新規作成</a>
    @endif
  </div>

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
  <table>
    <thead>
      <tr>
        <td>ID</td>
        <td>Date</td>
        <td>ScheduleId</td>
        <td>SheetId</td>
        <td>Sheet名</td>
        <td>名前</td>
        <td>メールアドレス</td>
        <td>isCanceled</td>
        <td>アクション</td>
      </tr>
    </thead>
    <tbody>
      @foreach ($reservations as $reservation)
      <tr>
        <td>{{ $reservation->id }}</td>
        <td> {{ $reservation->date }}</td>
        <td>{{ $reservation->schedule_id }}</td>
        <td>{{ $reservation->sheet_id }}</td>
        <td>{{ strtoupper($reservation->sheet->row) }}{{ $reservation->sheet->column }}</td>
        <td>{{ $reservation->name }}</td>
        <td>{{ $reservation->email }}</td>
        <td>{{ $reservation->is_canceled ? 'キャンセル済' : '' }}</td>
        <td>
          <a href="/admin/reservations/{{ $reservation->id }}/edit" class="linkButton">
            編集
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection