<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movies.index', ['movies' => $movies]);
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(CreateMovieRequest $request)
    {
        Movie::create($request->validated());
        return redirect()->route('admin.movies.index')->with('success', '映画を作成しました');
    }

    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', ['movie' => $movie]);
    }

    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $movie->update($request->validated());
        return redirect()->route('admin.movies.index')->with('success', '映画を更新しました');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', '映画を削除しました');
    }
}
