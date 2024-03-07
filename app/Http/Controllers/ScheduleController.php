<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Schedule;
use Illuminate\Http\Request; // リクエスト処理をする際はここのインポートは必須！ 

class ScheduleController extends Controller
{
  /**
   * Schedule一覧画面
   */
  public function page_get_schedules_admin()
  {
    $moviesWithSchedules = Movie::with('schedules')->get();

    $hasAdmin = true;
    return view('schedules', ['moviesWithSchedules' => $moviesWithSchedules, 'hasAdmin' => $hasAdmin]);
  }

  /**
   * スケジュール新規登録画面
   */
  public function page_get_schedules_admin_create(Request $request, string $id)
  {
    $movie = Movie::find($id);

    if (!$movie) {
      return redirect('/admin/movies')->with('error', '指定されたIDの映画が見つかりませんでした。');
    }

    return view("schedules_edit", ['movie' => $movie]);
  }

  /**
   * スケジュール編集画面
   */
  public function page_get_schedules_admin_edit(Request $request, string $scheduleId)
  {
    $schedule = Schedule::find($scheduleId);
    if (!$schedule) {
      return redirect('/admin/movies')->with('error', '指定されたIDのスケジュールが見つかりませんでした。');
    }

    $schedule['start_time_date'] = $schedule->start_time->format('Y-m-d');
    $schedule['start_time_time'] = $schedule->start_time->format('H:i');
    $schedule['end_time_date'] = $schedule->end_time->format('Y-m-d');
    $schedule['end_time_time'] = $schedule->end_time->format('H:i');

    $movie = Movie::find($schedule->movie_id);

    if (!$movie) {
      return redirect('/admin/movies')->with('error', '指定されたIDのスケジュールが見つかりませんでした。');
    }
    return view("schedules_edit", ['movie' => $movie, 'schedule' => $schedule]);
  }

  public function page_get_schedules_admin_json()
  {
    $moviesWithSchedules = Movie::with('schedules')->get();
    return response()->json($moviesWithSchedules); // jsonで出力するならこれ
  }
}
