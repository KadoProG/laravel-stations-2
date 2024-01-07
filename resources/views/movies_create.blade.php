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

    <div style="position: relative;">
      <label for="genre_id">ジャンル:</label>
      <select name="genre_id" id="genre_id" class="form-control" value="{{ old('genre_id', $movie->genre_id ?? '') }}" style="width:120px; clip:rect(0px,120px,34px,100px); position:absolute; top: 0; height: 34px" onchange="select(this);">
        <option value="" {{ old('genre_id', isset($movie) ? '':'selected') }}></option>
        @foreach($genres as $genre)
        <option value="{{ $genre->id }}" {{ old('genre_id', isset($movie->genre_id) ? ($genre->id == $movie->genre_id ? 'selected' : ''):'') }}>{{ $genre->name }}</option>
        @endforeach
      </select>
      <input id="t1" name="genre" type="text" required value="{{ old('genre', isset($movie->genre_id) ? $movie->genre->name : '')}}" style="width:100px;margin-right:20px; line-height: 30px; margin: 0; padding: 0; box-sizing: border-box">
      <script language="javascript">
        function select(obj) {
          document.getElementById("t1").value = obj.options[obj.selectedIndex].text;
        }
      </script>
    </div>
    @error('genre_id')
    <p style="color: red;">{{ $message }}</p>
    @enderror
    @error('genre')
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