@extends('layouts.layout')

@section('title', 'シート一覧画面')

@section('content')


<h1>{{(isset($movie_id) && isset($schedule_id)) ? 'シートを選択する': 'シート一覧'}}</h1>


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

    <!-- /movies/movie_id/schedules/schedule_id/reservations/create -->

    <tr>
      <td>
        <a href="{{ route('sheets.reserve.edit', ['movie_id' => $movie_id, 'schedule_id' => $schedule_id, 'sheet_id' => $sheet->id]) }}">
          {{ $sheet->row }}-{{ $sheet->column }}
        </a>
      </td>
      @php
      $currentRow = $sheet->row;
      @endphp
      @else
      <td>
        <a href="{{ route('sheets.reserve.edit', 
          [
            'movie_id' => $movie_id,
            'schedule_id' => $schedule_id, 
            'sheet_id' => $sheet->id
          ]) }}">{{ $sheet->row }}-{{ $sheet->column }}</a>
      </td>
      @endif
      @endforeach
  </tbody>

</table>

@endsection