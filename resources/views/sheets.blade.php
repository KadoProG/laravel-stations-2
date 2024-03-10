@extends('layouts.layout')

@section('title', (isset($movie_id) && isset($schedule_id)) ? 'シート選択画面': 'シート一覧画面')

@section('content')


<h1>{{(isset($movie_id) && isset($schedule_id)) ? 'シートを選択してください': 'シート一覧'}}</h1>


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

  table tr td>* {
    width: 100%;
    display: inline-block;
    background: transparent;
    border: none;
    height: 24px;
    cursor: pointer;
    margin: 2px;
  }

  table tr td>*:hover {
    background: #fff;
  }
</style>

@if (isset($movie_id) && isset($schedule_id))
<p>ムービーID: {{$movie_id}}</p>
<p>スケジュールID: {{$schedule_id}}</p>
@endif
<table>
  <thead>
    <tr>
      <th>・</th>
      <th>・</th>
      <th>スクリーン</th>
      <th>・</th>
      <th>・</th>
    </tr>
  </thead>
  <tbody>

    @php
    $currentRow = null;
    @endphp

    @foreach ($sheets as $sheet)
    @if($currentRow !== $sheet->row)

    @if($currentRow !== null)
    </tr>
    @endif

    <tr>
      <td>
        @if (isset($movie_id) && isset($schedule_id))
        <a href="{{ route('sheets.reserve.edit', 
          [
            'movie_id' => $movie_id,
            'schedule_id' => $schedule_id, 
            'sheet_id' => $sheet->id
          ]) }}">
          @endif
          {{ $sheet->row }}-{{ $sheet->column }}
          @if (isset($movie_id) && isset($schedule_id))
        </a>
        @endif
      </td>
      @php
      $currentRow = $sheet->row;
      @endphp
      @else
      <td>
        @if (isset($movie_id) && isset($schedule_id))
        <a href="{{ route('sheets.reserve.edit', 
          [
            'movie_id' => $movie_id,
            'schedule_id' => $schedule_id, 
            'sheet_id' => $sheet->id
          ]) }}">
          @endif
          {{ $sheet->row }}-{{ $sheet->column }}
          @if (isset($movie_id) && isset($schedule_id))
        </a>
        @endif
      </td>
      @endif
      @endforeach
  </tbody>

</table>

@endsection