<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\Sheet;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request; // リクエスト処理をする際はここのインポートは必須！ 
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class SheetController extends Controller
{
  /**
   * シート一覧画面
   */
  public function page_get_sheets()
  {
    $sheets = Sheet::all();
    return view('sheets', ['sheets' => $sheets]);
  }

  /**
   * 予約一覧画面（admin）
   */
  public function page_get_reservations_admin()
  {
    $today = Carbon::now()->toDateString(); // 今日
    $reservations = Reservation::with(['sheet', 'schedule.movie'])
      ->whereDate('date', '>=', $today) // 本日以降のみ表示
      ->get();

    return view('reservations', ["reservations" => $reservations, 'hasAdmin' => true]);
  }

  /**
   * シート選択画面
   */
  public function page_get_sheets_register(Request $request, string $movie_id, string $schedule_id)
  {
    try {
      $validatedData = $request->validate([
        'date' => 'required|date',
      ]);
    } catch (ValidationException $e) {
      // バリデーションエラーが発生した場合の処理
      return response()->json(['error' => $e->validator->errors()], 400);
    }

    $sheets = Sheet::with(['reservations' => function ($query) use ($schedule_id) {
      $query->where('schedule_id', $schedule_id);
    }])->get();


    return view('sheets', [
      'sheets' => $sheets, 'movie_id' => $movie_id,
      'schedule_id' => $schedule_id, 'date' => $validatedData['date']
    ]);
  }

  /**
   * シート最終登録画面
   */
  public function page_get_sheets_reserve_edit(Request $request, string $movie_id = '', string $schedule_id = '', bool $hasAdmin = false)
  {
    try {
      if (!$hasAdmin) {
        $validatedData = $request->validate([
          'sheetId' => 'required|exists:sheets,id',
          'date' => 'required|date',
        ]);

        $sheetId = $validatedData['sheetId'];

        // 特定のSheetに関連する予約を取得
        $sameSheet = Reservation::where('sheet_id', $sheetId)
          ->where('schedule_id', $schedule_id)
          ->where('is_canceled', false)->first();

        if ($sameSheet) {
          return response()->json(['error' => '既に予約済み'], 400);
        }
        return view('reservations_edit', [
          'movie_id' => $movie_id,
          'schedule_id' => $schedule_id,
          'sheetId' => $validatedData['sheetId'],
          'date' => $validatedData['date'],
          'hasAdmin' => false,
        ]);
      } else {
        return view('reservations_edit', [
          'hasAdmin' => true,
        ]);
      }
    } catch (ValidationException $e) {
      // バリデーションエラーが発生した場合の処理
      return response()->json(['error' => $e->validator->errors()], 400);
    }
  }

  /**
   * 予約追加画面(admin)
   */
  public function page_get_reservations_create_admin(Request $request)
  {
    return $this->page_get_sheets_reserve_edit($request, '', '', true);
  }

  /**
   * 予約編集画面(admin)
   */
  public function page_get_reservations_edit_admin(Request $request, string $id)
  {
    $reservation = Reservation::with('schedule.movie')->find($id);

    if (!$reservation) {
      return redirect()->back()->with('error', '指定されたIDの予約が見つかりませんでした。');
    }

    return view('reservations_edit', [
      'reservation' => $reservation,
      'hasAdmin' => true,
    ]);
  }

  /**JSONで出力 */
  public function page_get_reserve_json(Request $request)
  {
    $today = Carbon::now()->toDateString(); // 今日
    $reservations = Reservation::with(['sheet', 'schedule.movie'])
      ->whereDate('date', '>=', $today) // 本日以降のみ表示
      ->get();

    return response()->json(['reservations' => $reservations,]); // jsonで出力するならこれ
  }
}
