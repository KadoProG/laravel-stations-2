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

  public function movies(Request $request)
  {
    // getParams関連を取得
    $is_showing = $request->input('is_showing');
    $keyword = $request->input('keyword');

    // 条件を適用してデータを取得
    $movies = Movie::when(isset($is_showing), function ($query) use ($is_showing) {
      return $query->where('is_showing', $is_showing);
    })
      ->when(isset($keyword), function ($query) use ($keyword) {
        return $query->where(function ($query) use ($keyword) {
          $query->where('description', 'LIKE', '%' . $keyword . '%')
            ->orWhere('title', 'LIKE', '%' . $keyword . '%');
        });
      })
      ->paginate(20, ['*'], 'page'); // ここでページネーション用のクエリパラメータを指定

    // データが存在しない場合はstatus404を返す
    if ($movies->isEmpty()) {
      abort(404);
    }

    return view('movies', ['movies' => $movies, 'is_showing' => $is_showing, 'keyword' => $keyword]);
  }


  // 映画の新規登録に遷移
  public function movies_create()
  {
    return view('movies_create');
  }

  // 映画の新規登録
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

      return redirect('/admin/movies')->with('success', '映画が作成されました。');
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

  // 映画の編集画面に遷移
  public function movies_edit(Request $request, string $id)
  {
    $movie = Movie::find($id);

    if (!$movie) {
      return redirect('/admin/movies')->with('error', '指定されたIDの映画が見つかりませんでした。');
    }
    return view("movies_create", ['movie' => $movie]);
  }

  // 映画の更新
  public function movies_update(Request $request, $id)
  {
    try {
      $validatedData = $request->validate([
        'title' => "required|unique:movies,title,$id", // $idを使って編集中のレコードを除外
        'image_url' => "required|url",
        'published_year' => "required|integer",
        'is_showing' => "required|boolean",
        'description' => "required",
      ]);

      // 既存のデータを取得
      $movie = Movie::find($id);

      if (!$movie) {
        // 該当のIDのデータが存在しない場合の処理
        return redirect('/admin/movies')->with('error', '指定されたIDの映画が見つかりませんでした。');
      }

      // データを更新
      $movie->fill($validatedData)->save();

      return redirect('/admin/movies')->with('success', '映画が更新されました。');
    } catch (ValidationException $e) {
      // バリデーションエラーの場合
      return redirect("/admin/movies/{$id}/edit")->withErrors($e->errors())->withInput($request->all());
    } catch (\Exception $e) {
      // その他の例外の場合
      return redirect("/admin/movies/{$id}/edit")->with([
        'error' => 'エラーの可能性: ' . $e->getMessage(),
        'title' => $request->input('title'),
        'image_url' => $request->input('image_url'),
        'published_year' => $request->input('published_year'),
        'is_showing' => $request->input('is_showing'),
        'description' => $request->input('description'),
      ]);
    }
  }

  // 映画の削除
  public function movies_delete(Request $request, $id)
  {
    // 既存のデータを取得
    $movie = Movie::find($id);

    if (!$movie) {
      // 該当のIDのデータが存在しない場合の処理
      abort(404, '指定されたIDの映画が見つかりませんでした。');
    }

    try {
      // データを削除
      $movie->delete();

      return redirect('/admin/movies')->with('success', '映画が削除されました。');
    } catch (\Exception $e) {
      // 例外
      return redirect("/admin/movies")->with('error', 'エラー: ' . $e->getMessage());
    }
  }
}
