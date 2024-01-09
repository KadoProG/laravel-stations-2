@extends('layouts.layout')

@section('title', 'ムービー一覧')

@section('content')
<h1>シート一覧</h1>

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
      <td>{{ $sheet->row }}-{{ $sheet->column }}</td>
      @php
      $currentRow = $sheet->row;
      @endphp
      @else
      <td>{{ $sheet->row }}-{{ $sheet->column }}</td>
      @endif
      @endforeach

  </tbody>

</table>

@endsection