<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Sheet;
use Illuminate\Http\Request; // リクエスト処理をする際はここのインポートは必須！ 

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
  public function page_get_sheets_register(string $movie_id, string $schedule_id)
  {
    $sheets = Sheet::all();
    return view('sheets', ['sheets' => $sheets, 'movie_id' => $movie_id, 'schedule_id' => $schedule_id]);
  }

  /**
   * シート最終登録画面
   */
  public function page_get_sheets_reserve_edit(Request $request, string $movie_id, string $schedule_id)
  {
    // $sheet_id を Request オブジェクトから取得
    $sheet_id = $request->query('sheet_id');
    return view('sheets_reserve', [
      'movie_id' => $movie_id, 'schedule_id' => $schedule_id,
      'sheet_id' => $sheet_id
    ]);
  }

  /**JSONで出力 */
  public function page_get_reserve_json(Request $request)
  {
    $reservations = Reservation::all();
    return response()->json(['reservations' => $reservations]); // jsonで出力するならこれ
  }
}
