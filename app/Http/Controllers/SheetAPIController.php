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
  public function post_reservations_store(Request $request, bool $hasAdmin = false)
  {
    try {
      // バリデーションフォーマット
      $validatedData = $hasAdmin ? $request->validate([
        'movie_id' => "required|exists:movies,id",
        'schedule_id' => "required|exists:schedules,id",
        'sheet_id' => "required|exists:sheets,id",
        'date' => "required|date",
        'name' => "required|string",
        'email' => "required|email",
      ]) : $request->validate([
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

      if (!$hasAdmin) {
        return redirect("/movies/{$request['movie_id']}")
          ->with('success', '予約が完了しました！');
      } else {
        return redirect("/admin/reservations")
          ->with('success', '予約が完了しました！');
      }
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

  /**
   * 予約登録（admin）
   */
  public function post_reservations_admin(Request $request)
  {
    return $this->post_reservations_store($request, true);
  }

  /**
   * 予約更新（admin）
   */
  public function patch_reservations_update(Request $request, $id)
  {
    try {
      $request['id'] = $id; // こっちは何故か有効…
      // バリデーションフォーマット
      $validatedData = $request->validate([
        'id' => "required|exists:reservations,id",
        'schedule_id' => "required|exists:schedules,id",
        'movie_id' => "required|exists:movies,id",
        'sheet_id' => "required|exists:sheets,id",
        'date' => "required|date",
        'name' => "required|string",
        'email' => "required|email",
      ]);

      DB::beginTransaction();

      $reservation = Reservation::find($id);

      // 重複チェック
      $existingReservation = Reservation::where('schedule_id', $validatedData['schedule_id'])
        ->where('sheet_id', $validatedData['sheet_id'])
        ->where('is_canceled', false)
        ->where('id', '!=', $validatedData['id'])
        ->first();

      if ($existingReservation) {
        // 重複がある場合の処理（エラーメッセージ表示等）
        return redirect()
          ->back()
          ->with('error', 'その座席はすでに予約済みです')
          ->withInput($request->all());
      }

      $reservation->fill($validatedData);
      $reservation->save();

      DB::commit();

      return redirect('/admin/reservations/')->with('success', 'スケジュールが更新されました。');
    } catch (ValidationException $e) {
      info('予約更新時エラー１: ' . $e->getMessage());

      // バリデーションエラーの場合
      return redirect()->back()->withErrors($e->errors())->withInput($request->all());
    } catch (\Exception $e) {
      info('予約更新時エラー２: ' . $e->getMessage());

      // その他の例外の場合
      DB::rollBack();

      abort(500, $e->getMessage());
    }
  }

  /**
   * 予約の削除
   */
  public function delete_reservations_delete(Request $request, $id)
  {
    $reservation = Reservation::find($id);
    if (!$reservation) {
      abort(404, '指定されたIDの予約が見つかりませんでした。');
    }

    try {
      // データを削除
      $reservation->delete();

      return redirect('/admin/reservations')->with('success', 'スケジュールが削除されました。');
    } catch (\Exception $e) {
      // 例外
      return redirect("/admin/reservations")->with('error', 'エラー: ' . $e->getMessage());
    }
  }
}
