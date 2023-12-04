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
  <h1>ムービーを作成・編集する</h1>

  {{-- バリデーションエラーメッセージの表示 --}}
  @if ($errors->any())
  <div style="color: red;">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="/admin/movies/{{ isset($movie) ? $movie->id . '/update/':'store' }}" method="POST">
    @csrf

    @if (isset($movie))
    @method('PATCH') {{-- Use PATCH method for updates --}}
    @endif

    <p>タイトル</p>
    <input type="text" name="title" required value="{{ old('title', $movie->title ?? '') }}">
    {{-- エラーメッセージの表示 --}}
    @error('title')
    <p style="color: red;">{{ $message }}</p>
    @enderror

    <p>画像URL</p>
    <input type="url" name="image_url" required value="{{ old('image_url', $movie->image_url ?? '') }}">
    @error('image_url')
    <p style="color: red;">{{ $message }}</p>
    @enderror

    <p>公開年</p>
    <input type="number" name="published_year" required value="{{ old('published_year', $movie->published_year ?? '') }}">
    @error('published_year')
    <p style="color: red;">{{ $message }}</p>
    @enderror

    <p>上映中・上映予定</p>
    <label for="is_showing">上映中</label>
    <input type="hidden" name="is_showing" value="0">
    <input type="checkbox" name="is_showing" value="1" id="is_showing" {{ old('is_showing', $movie->is_showing ?? '') == "1" ? 'checked' : '' }}>

    <p>概要</p>
    <textarea name="description" cols="30" rows="10" required>{{ old('description', $movie->description ?? '') }}</textarea>
    @error('description')
    <p style="color: red;">{{ $message }}</p>
    @enderror

    <button type="submit">送信する</button>
  </form>
</body>

</html>