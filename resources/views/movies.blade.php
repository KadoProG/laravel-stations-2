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
  <h1>ムービー一覧</h1>
  <ul class="movies">
    @if (count($movies) === 0)
    <li>ブログはありません</li>
    @endif
    @foreach ($movies as $movie)
    <li>
      <p>{{ $movie->id }} :タイトル: {{ $movie->title }}</p>
      <ul>
        <li>公開年:{{$movie->published_year}}</li>
        <li>現　在:{{$movie->is_showing ? "上映中": "上映予定"}}</li>
        <li>説　明:{{$movie->description}}</li>
        <li>登録日:{{$movie->created_at}}</li>
        <li>更新日:{{$movie->updated_at}}</li>
      </ul>
      <img src="{{$movie->image_url}}" alt="画像" width="300" height="200">
    </li>
    @endforeach
  </ul>
</body>

</html>