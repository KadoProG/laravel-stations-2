<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request; // リクエスト処理をする際はここのインポートは必須！ 

class ScheduleController extends Controller
{
  // Schedule取得画面
  public function page_get_schedules_admin()
  {
    // $schedules = Schedule::orderBy('');
    $moviesWithSchedules = Movie::with('schedules')->get();

    $hasAdmin = true;
    return view('schedules', ['moviesWithSchedules' => $moviesWithSchedules, 'hasAdmin' => $hasAdmin]);
  }

  // スケジュール新規登録
  public function page_get_schedules_admin_create(Request $request, string $id)
  {
    $movie = Movie::find($id);

    if (!$movie) {
      return redirect('/admin/movies')->with('error', '指定されたIDの映画が見つかりませんでした。');
    }

    return view("schedules_edit", ['movie' => $movie]);
  }

  // スケジュール編集画面
  public function page_get_schedules_admin_edit()
  {
  }

  public function page_get_schedules_admin_json()
  {
    // $schedules = Schedule::orderBy('');
    $moviesWithSchedules = Movie::with('schedules')->get();
    return response()->json($moviesWithSchedules); // jsonで出力するならこれ
  }
}
