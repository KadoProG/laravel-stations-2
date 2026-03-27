<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;

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
        Movie::create([
            'title' => $request->title,
            'image_url' => $request->image_url,
            'published_year' => $request->published_year,
            'description' => $request->description,
            'is_showing' => $request->is_showing,
        ]);
        return redirect()->route('admin.movies.index')->with('success', '映画を作成しました');
    }

    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', ['movie' => $movie]);
    }

    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $movie->update($request->all());
        return redirect()->route('admin.movies.index')->with('success', '映画を更新しました');
    }
}
