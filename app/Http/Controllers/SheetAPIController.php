<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Reservation;
use App\Models\Schedule;
use Illuminate\Http\Request; // リクエスト処理をする際はここのインポートは必須！ 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SheetAPIController extends Controller
{
  /**
   * スケジュールの新規登録
   */
  public function post_reservations_store(Request $request)
  {
    try {
      $validatedData = $request->validate([
        'schedule_id' => "required|exists:schedules,id",
        'sheet_id' => "required|exists:sheets,id",
        'movie_id' => 'required|exists:movies,id',
        'date' => "required|date_format:Y-m-d",
        'email' => "required|email",
      ]);

      DB::beginTransaction();

      // 新しいインスタンスの作成
      $schedule_data = new Reservation();
      $schedule_data->fill($validatedData);
      $schedule_data->save();

      DB::commit();

      return redirect("/movies/{$request['movie_id']}")->with('success', '予約が完了しました！');
    } catch (ValidationException $e) {
      info('スケジュール作成時エラー１: ' . $e->getMessage());

      // バリデーションエラーの場合
      return redirect("/movies/{$request['movie_id']}/schedules/{$request['schedule_id']}/reservations/create?sheet_id={$request['sheet_id']}")->withErrors($e->errors())
        ->withInput($request->all());
    } catch (\Exception $e) {
      info('スケジュール新規作成時エラー２: ' . $e->getMessage());

      // その他の例外の場合
      DB::rollBack();

      abort(500, $e->getMessage());

      return redirect("/movies/{$request['movie_id']}/schedules/{$request['schedule_id']}/reservations/create?sheet_id={$request['sheet_id']}")->with([
        'error' => 'エラーの可能性: ' . $e->getMessage(),
        'movie_id' => $request->input('movie_id'),
        'start_time_date' => $request->input('start_time_date'),
        'start_time_time' => $request->input('start_time_time'),
        'end_time_date' => $request->input('end_time_date'),
        'end_time_time' => $request->input('end_time_time'),
      ]);
    }
  }

  // /**
  //  * 映画の更新
  //  */
  // public function patch_schedules_update(Request $request, string $id)
  // {
  //   try {
  //     $request['id'] = $id; // こっちは何故か有効…

  //     $validatedData = $request->validate([
  //       'id' => 'required|exists:schedules,id',
  //       'movie_id' => 'required|exists:movies,id',
  //       'start_time_date' => "required|date_format:Y-m-d",
  //       'start_time_time' => "required|date_format:H:i",
  //       'end_time_date' => "required|date_format:Y-m-d",
  //       'end_time_time' => "required|date_format:H:i",
  //     ]);

  //     // ミューテータを使用してstart_timeとend_timeを結合
  //     $validatedData['start_time'] = $validatedData['start_time_date'] . ' ' . $validatedData['start_time_time'];
  //     $validatedData['end_time'] = $validatedData['end_time_date'] . ' ' . $validatedData['end_time_time'];

  //     // 追加のバリデーション
  //     $additionalValidation = Validator::make($validatedData, [
  //       'id' => 'required|exists:schedules,id',
  //       'movie_id' => 'required|exists:movies,id',
  //       'start_time_date' => "required|date_format:Y-m-d|schedule_date_time_after_start_date_validation",
  //       'start_time_time' => "required|date_format:H:i|schedule_date_time_after_start_time_validation|schedule_date_time_diff_minute_validation",
  //       'end_time_date' => "required|date_format:Y-m-d|schedule_date_time_after_start_date_validation",
  //       'end_time_time' => "required|date_format:H:i|schedule_date_time_after_start_time_validation|schedule_date_time_diff_minute_validation",
  //       "start_time" => "required|date_format:Y-m-d H:i",
  //       "end_time" => "required|date_format:Y-m-d H:i",
  //     ])->validate();


  //     DB::beginTransaction();

  //     // 既存のデータを取得
  //     $schedule = Schedule::find($id);

  //     if (!$schedule) {
  //       // 該当のIDのデータが存在しない場合の処理
  //       return redirect('/admin/movies')->with('error', '指定されたIDのスケジュールが見つかりませんでした。');
  //     }

  //     // データを更新
  //     $schedule->fill($additionalValidation);
  //     $schedule->save();

  //     DB::commit();

  //     return redirect('/admin/movies/' . $request['movie_id'])->with('success', 'スケジュールが更新されました。');
  //   } catch (ValidationException $e) {
  //     info('映画更新時エラー１: ' . $e->getMessage());

  //     // バリデーションエラーの場合
  //     return redirect("/admin/schedules/{$id}/edit")->withErrors($e->errors())->withInput($request->all());
  //   } catch (\Exception $e) {
  //     info('映画更新時エラー２: ' . $e->getMessage());


  //     // その他の例外の場合
  //     DB::rollBack();

  //     abort(500, $e->getMessage());

  //     return redirect("/admin/schedules/{$id}/edit")->with([
  //       'error' => 'エラーの可能性: ' . $e->getMessage(),
  //       'id' => $request->input('id'),
  //       'movie_id' => $request->input('movie_id'),
  //       'start_time_date' => $request->input('start_time_date'),
  //       'start_time_time' => $request->input('start_time_time'),
  //       'end_time_date' => $request->input('end_time_date'),
  //       'end_time_time' => $request->input('end_time_time'),
  //     ]);
  //   }
  // }

  // /**
  //  * スケジュールの削除
  //  */
  // public function delete_schedules_delete(Request $request, $id)
  // {
  //   // 既存のデータを取得
  //   $schedule = Schedule::find($id);

  //   if (!$schedule) {
  //     // 該当のIDのデータが存在しない場合の処理
  //     abort(404, '指定されたIDの映画が見つかりませんでした。');
  //   }

  //   try {
  //     // データを削除
  //     $schedule->delete();

  //     return redirect('/admin/movies')->with('success', 'スケジュールが削除されました。');
  //   } catch (\Exception $e) {
  //     // 例外
  //     return redirect("/admin/movies")->with('error', 'エラー: ' . $e->getMessage());
  //   }
  // }
}
