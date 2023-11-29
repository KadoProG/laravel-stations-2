<?php

namespace App\Http\Controllers;

use App\Practice;
use App\Models\Movie;
use Illuminate\Http\Request; // リクエスト処理をする際はここのインポートは必須！ 
use Illuminate\Validation\ValidationException;

class PracticeController extends Controller
{
  public function sample()
  {
    return view('practice');
  }

  public function sample2()
  {
    $test = 'practice2';
    return view("practice2", ["testParam" => $test]);
  }

  public function sample3()
  {
    $test = 'test';
    return view("practice3", ["testParam" => $test]);
  }

  public function getPractice()
  {
    $practices = Practice::all();
    return view('getPractice', ['practices' => $practices]);
  }

  public function movies()
  {
    $movies = Movie::all();
    return view('movies', ['movies' => $movies]);
    // return response()->json($movies); // jsonで出力するならこれ
  }

  public function movies_create()
  {
    return view('movies_create');
  }

  public function movies_store(Request $request)
  {
    try {
      $validatedData = $request->validate([
        'title' => "required|unique:movies,title",
        'image_url' => "required|url",
        'published_year' => "required|integer",
        'is_showing' => "required|boolean",
        'description' => "required",
      ]);

      // 新しいインスタンスの作成
      $Movie_data = new Movie;
      $Movie_data->fill($validatedData)->save();

      return redirect('/admin/movies');
    } catch (ValidationException $e) {
      // バリデーションエラーの場合
      return redirect('/admin/movies/create')->withErrors($e->errors())
        ->withInput($request->all());
    } catch (\Exception $e) {
      // その他の例外の場合
      return redirect('/admin/movies/create')->with([
        'error' => 'エラーの可能性: ' . $e->getMessage(),
        'title' => $request->input('title'),
        'image_url' => $request->input('image_url'),
        'published_year' => $request->input('published_year'),
        'is_showing' => $request->input('is_showing'),
        'description' => $request->input('description'),
      ]);
    }
  }
}
