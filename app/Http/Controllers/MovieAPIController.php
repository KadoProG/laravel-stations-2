<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request; // リクエスト処理をする際はここのインポートは必須！ 
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MovieAPIController extends Controller
{
  /**
   * 映画の新規登録 
   */
  public function movies_store(Request $request)
  {
    try {
      $validatedData = $request->validate([
        'title' => "required|unique:movies,title",
        'image_url' => "required|url",
        'published_year' => "required|integer",
        'is_showing' => "required|boolean",
        'genre' => 'required|string',
        'description' => "required",
      ]);

      DB::beginTransaction();

      // ジャンルを登録 or 取得
      $genre = Genre::firstOrCreate(['name' => $validatedData['genre']]);
      $genreId = $genre->id;

      // 新しいインスタンスの作成
      $Movie_data = new Movie();
      $Movie_data->fill($validatedData);
      $Movie_data->genre_id = $genreId;
      $Movie_data->save();

      DB::commit();

      return redirect('/admin/movies')->with('success', '映画が作成されました。');
    } catch (ValidationException $e) {
      info('映画新規作成時エラー１: ' . $e->getMessage());

      // バリデーションエラーの場合
      return redirect('/admin/movies/create')->withErrors($e->errors())
        ->withInput($request->all());
    } catch (\Exception $e) {
      info('映画新規作成時エラー２: ' . $e->getMessage());

      // その他の例外の場合
      DB::rollBack();

      abort(500, $e->getMessage());

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

  /**
   * 映画の更新
   */
  public function movies_update(Request $request, $id)
  {
    try {
      $validatedData = $request->validate([
        'title' => "required|unique:movies,title,$id", // $idを使って編集中のレコードを除外
        'image_url' => "required|url",
        'published_year' => "required|integer",
        'is_showing' => "required|boolean",
        'genre' => 'required|string',
        'description' => "required",
      ]);

      DB::beginTransaction();

      $genre = Genre::firstOrCreate(['name' => $validatedData['genre']]);
      $genreId = $genre->id;

      // 既存のデータを取得
      $movie = Movie::find($id);

      if (!$movie) {
        // 該当のIDのデータが存在しない場合の処理
        return redirect('/admin/movies')->with('error', '指定されたIDの映画が見つかりませんでした。');
      }

      // データを更新
      $movie->fill($validatedData);
      $movie->genre_id = $genreId;
      $movie->save();

      DB::commit();

      return redirect('/admin/movies')->with('success', '映画が更新されました。');
    } catch (ValidationException $e) {
      info('映画更新時エラー１: ' . $e->getMessage());

      // バリデーションエラーの場合
      return redirect("/admin/movies/{$id}/edit")->withErrors($e->errors())->withInput($request->all());
    } catch (\Exception $e) {
      info('映画更新時エラー２: ' . $e->getMessage());


      // その他の例外の場合
      DB::rollBack();

      abort(500, $e->getMessage());

      return redirect("/admin/movies/{$id}/edit")->with([
        'error' => 'エラーの可能性: ' . $e->getMessage(),
        'title' => $request->input('title'),
        'image_url' => $request->input('image_url'),
        'published_year' => $request->input('published_year'),
        'is_showing' => $request->input('is_showing'),
        'description' => $request->input('description'),
        'genre' => $request->input('genre'),
      ]);
    }
  }

  /**
   * 映画の削除
   */
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
