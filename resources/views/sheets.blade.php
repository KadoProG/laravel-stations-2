<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Practice</title>
  <link rel="stylesheet" href="/css/app.css">
</head>

<body>
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
</body>

</html>