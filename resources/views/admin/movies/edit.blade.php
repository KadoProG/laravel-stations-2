@extends('layouts.app')

@section('content')
<h1 class="mb-4">映画編集</h1>
@if (session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif

@if ($errors->any())
@foreach ($errors->all() as $error)
<div class="alert alert-danger">
  {{ $error }}
</div>
@endforeach
@endif

<form action="{{ route('admin.movies.update', $movie->id) }}" method="post">
  @csrf
  @method('PUT')
  <div class="form-group">
    <label for="title">タイトル</label>
    <input type="text" name="title" id="title" class="form-control" required value="{{ $movie->title }}">
    <label for="image_url">画像URL</label>
    <input type="text" name="image_url" id="image_url" class="form-control" required value="{{ $movie->image_url }}">
    <label for="published_year">公開年</label>
    <input type="text" name="published_year" id="published_year" class="form-control" required value="{{ $movie->published_year }}">
    <label for="description">概要</label>
    <input type="text" name="description" id="description" class="form-control" required value="{{ $movie->description }}">
  </div>
  <div class="form-group">
    @php($isShowing = old('is_showing', $movie->is_showing))
    <div class="mb-2">上映中かどうか</div>
    <div class="form-check form-check-inline">
      <input type="radio" name="is_showing" id="is_showing_1" class="form-check-input" value="1" {{ $isShowing == 1 || $isShowing === true ? 'checked' : '' }}>
      <label class="form-check-label" for="is_showing_1">上映中</label>
    </div>
    <div class="form-check form-check-inline">
      <input type="radio" name="is_showing" id="is_showing_0" class="form-check-input" value="0" {{ $isShowing == 0 || $isShowing === false ? 'checked' : '' }}>
      <label class="form-check-label" for="is_showing_0">上映終了</label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">更新</button>
</form>
@endsection