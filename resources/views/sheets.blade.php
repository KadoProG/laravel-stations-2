@extends('layouts.layout')

@section('title', (isset($movie_id) && isset($schedule_id)) ? 'シート選択画面': 'シート一覧画面')

@section('content')



<div class="form">
  <h1>{{(isset($movie_id) && isset($schedule_id)) ? 'シート選択': 'シート一覧'}}</h1>
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
  <div class="formTextField">
    <div>
      <p>ムービーID</p>
    </div>
    <div>
      <p>{{ $movie_id }}</p>
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
      <p>日付</p>
    </div>
    <div>
      <p>{{ $date }}</p>
    </div>
  </div>
  @endif

  <h3>シートを選択してください</h3>


  <style>
    table {
      margin: 0 auto;
    }

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
            'sheetId' => $sheet->id,
            'date' => \Carbon\Carbon::parse($date)->format('Y-m-d'),
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
            'sheetId' => $sheet->id,
            'date' => \Carbon\Carbon::parse($date)->format('Y-m-d'),
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
</div>

@endsection