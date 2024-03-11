<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request; // リクエスト処理をする際はここのインポートは必須！ 
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SheetAPIController extends Controller
{
  /**
   * スケジュールの新規登録
   */
  public function post_reservations_store(Request $request)
  {
    try {
      // バリデーションフォーマット
      $validatedData = $request->validate([
        'schedule_id' => "required|exists:schedules,id",
        'sheet_id' => "required|exists:sheets,id",
        'date' => "required|date",
        'name' => "required|string",
        'email' => "required|email",
      ]);

      // 重複チェック
      $existingReservation = Reservation::where('schedule_id', $validatedData['schedule_id'])
        ->where('sheet_id', $validatedData['sheet_id'])
        ->where('is_canceled', false)
        ->first();

      if ($existingReservation) {
        // 重複がある場合の処理（エラーメッセージ表示等）
        return redirect()
          ->back()
          ->with('error', 'その座席はすでに予約済みです')
          ->withInput($request->all());
      }


      DB::beginTransaction();

      // 重複がない場合はデータベースに保存
      Reservation::create($validatedData);

      DB::commit();

      return redirect("/movies/{$request['movie_id']}")
        ->with('success', '予約が完了しました！');
    } catch (ValidationException $e) {
      info('予約登録時エラー１: ' . $e->getMessage());

      return redirect()
        ->back()
        ->withErrors($e->errors())
        ->withInput($request->all());
    } catch (\Exception $e) {
      info('予約登録時エラー２: ' . $e->getMessage());

      // その他の例外の場合
      DB::rollBack();

      abort(500, $e->getMessage());
    }
  }
}
