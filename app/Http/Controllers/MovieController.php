<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Sheet;
use App\Models\Schedule;
use Illuminate\Http\Request; // リクエスト処理をする際はここのインポートは必須！ 

class MovieController extends Controller
{
  /**
   * ムービー一覧画面
   */
  public function movies(Request $request, bool $hasAdmin = false)
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

    return view('movies', ['movies' => $movies, 'is_showing' => $is_showing, 'keyword' => $keyword, 'hasAdmin' => $hasAdmin]);
  }

  /**
   * ムービー一覧画面（admin）
   */
  public function movie_admin(Request $request)
  {
    return $this->movies($request, true);
  }

  public function movie_detail(Request $request, $id)
  {
    $movie = Movie::find($id);

    if (!$movie) {
      return redirect('/admin/movies')->with('error', '指定されたIDの映画が見つかりませんでした。');
    }

    $schedules = Schedule::where('movie_id', $id)
      ->orderBy('start_time', 'asc')
      ->get();

    return view("movie_detail", ['movie' => $movie, 'schedules' => $schedules]);
  }


  /**movies一覧をJSONで出力 */
  public function movies_preview()
  {
    $movies = Movie::all();
    return response()->json($movies); // jsonで出力するならこれ
  }

  /**genres一覧をJSONで出力 */
  public function genres_preview()
  {
    $genres = Genre::all();
    return response()->json($genres); // jsonで出力するならこれ
  }

  /**sheets一覧をJSONで出力 */
  public function sheets_preview()
  {
    $sheets = Sheet::all();
    return response()->json($sheets); // jsonで出力するならこれ
  }

  /**sheets一覧をJSONで出力 */
  public function schedules_preview()
  {
    $schedules = Schedule::all();
    return response()->json($schedules); // jsonで出力するならこれ
  }


  /**JSONで出力 */
  public function schedules_test(Request $request)
  {
    return response()->json([]); // jsonで出力するならこれ
  }

  // 映画の新規登録に遷移
  public function movies_create()
  {
    $genres = Genre::all();
    return view("movies_create", ['genres' => $genres]);
  }

  // 映画の編集画面に遷移
  public function movies_edit(Request $request, string $id)
  {
    $movie = Movie::find($id);

    if (!$movie) {
      return redirect('/admin/movies')->with('error', '指定されたIDの映画が見つかりませんでした。');
    }

    $genres = Genre::all();
    return view("movies_create", ['movie' => $movie, 'genres' => $genres]);
  }

  public function sheets_get(Request $request)
  {
    $sheets = Sheet::all();
    return view('sheets', ['sheets' => $sheets]);
  }
}
