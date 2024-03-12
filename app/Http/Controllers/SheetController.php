<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Sheet;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request; // リクエスト処理をする際はここのインポートは必須！ 
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

    // 例: Sheetコントローラーなどでの利用
    $sheets = Sheet::all();

    info($sheets);

    return view('sheets', [
      'sheets' => $sheets, 'movie_id' => $movie_id,
      'schedule_id' => $schedule_id, 'date' => $validatedData['date']
    ]);
  }

  /**
   * シート最終登録画面
   */
  public function page_get_sheets_reserve_edit(Request $request, string $movie_id, string $schedule_id)
  {
    try {
      $validatedData = $request->validate([
        'sheetId' => 'required|exists:sheets,id',
        'date' => 'required|date',
      ]);

      return view('sheets_reserve', [
        'movie_id' => $movie_id,
        'schedule_id' => $schedule_id,
        'sheetId' => $validatedData['sheetId'],
        'date' => $validatedData['date'],
      ]);
    } catch (ValidationException $e) {
      // バリデーションエラーが発生した場合の処理
      return response()->json(['error' => $e->validator->errors()], 400);
    }
  }

  /**JSONで出力 */
  public function page_get_reserve_json(Request $request)
  {
    $reservations = Reservation::all();
    return response()->json(['reservations' => $reservations]); // jsonで出力するならこれ
  }
}
