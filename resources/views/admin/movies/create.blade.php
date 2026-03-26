@extends('layouts.app')

@section('content')
<h1 class="mb-4">映画登録</h1>
@if (session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif

@error('title')
<div class="alert alert-danger">
  {{ $message }}
</div>
@enderror

@error('image_url')
<div class="alert alert-danger">
  {{ $message }}
</div>
@enderror
@error('published_year')
<div class="alert alert-danger">
  {{ $message }}
</div>
@enderror

@error('description')
<div class="alert alert-danger">
  {{ $message }}
</div>
@enderror
@error('is_showing')
<div class="alert alert-danger">
  {{ $message }}
</div>
@enderror

<form action="{{ route('admin.movies.store') }}" method="post">
  @csrf
  <div class="form-group">
    <label for="title">タイトル</label>
    <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
    <label for="image_url">画像URL</label>
    <input type="text" name="image_url" id="image_url" class="form-control" required value="{{ old('image_url') }}">
    <label for="published_year">公開年</label>
    <input type="text" name="published_year" id="published_year" class="form-control" required value="{{ old('published_year') }}">
    <label for="description">概要</label>
    <input type="text" name="description" id="description" class="form-control" required value="{{ old('description') }}">
    @php($isShowing = old('is_showing', '1'))
    <div class="mb-2">上映中かどうか</div>
    <div class="form-check form-check-inline">
      <input type="radio" name="is_showing" id="is_showing_1" class="form-check-input" value="1" {{ $isShowing == 1 || $isShowing === true ? 'checked' : '' }}>
      <label class="form-check-label" for="is_showing_1">上映中</label>
    </div>
    <div class="form-check form-check-inline">
      <input type="radio" name="is_showing" id="is_showing_0" class="form-check-input" value="0" {{ $isShowing == 0 || $isShowing === false ? 'checked' : '' }}>
      <label class="form-check-label" for="is_showing_0">上映終了</label>
    </div>
    <button type="submit" class="btn btn-primary">登録</button>
  </div>
</form>
@endsection