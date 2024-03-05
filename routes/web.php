<?php

use App\Http\Controllers\MovieAPIController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\PracticeController;
use App\Http\Controllers\ScheduleAPIController;
use App\Http\Controllers\ScheduleController;

// Route::get('URL', [Controllerの名前::class, 'Controller内のfunction名']);
Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3', [PracticeController::class, 'sample3']);
Route::get('/getPractice', [PracticeController::class, 'getPractice']);

Route::get('/movies', [MovieController::class, 'movies']);
Route::get('/movies/{id}', [MovieController::class, 'movie_detail']);
Route::get('/admin/movies', [MovieController::class, 'movie_admin']);
Route::get('/admin/movies/create', [MovieController::class, 'movies_create']);
Route::post('/admin/movies/store', [MovieAPIController::class, 'movies_store']);
Route::get('/admin/movies/{id}/edit', [MovieController::class, 'movies_edit']);
Route::get('/admin/movies/{id}', [MovieController::class, 'movie_detail']);
Route::patch('/admin/movies/{id}/update', [MovieAPIController::class, 'movies_update']);
Route::delete('/admin/movies/{id}/destroy', [MovieAPIController::class, 'movies_delete']);

Route::get('/sheets', [MovieController::class, 'sheets_get']);

Route::get('/admin/movies/{id}/schedules/create', [ScheduleController::class, 'page_get_schedules_admin_create']); // スケジュール一覧表示
Route::post('/admin/movies/{id}/schedules/store', [ScheduleAPIController::class, 'post_schedules_store']); // スケジュール更新

Route::get('/admin/schedules', [ScheduleController::class, 'page_get_schedules_admin']); // スケジュール一覧表示
Route::get('/test/admin/schedules', [ScheduleController::class, 'page_get_schedules_admin_json']); // スケジュール一覧表示

// デバッグ用
Route::get('/test/genre', [MovieController::class, 'genres_preview']);
Route::get('/test/movie', [MovieController::class, 'movies_preview']);
Route::get('/test/sheet', [MovieController::class, 'sheets_preview']);
Route::get('/test/schedule', [MovieController::class, 'schedules_preview']);
Route::get('/test/scheduleTest', [MovieController::class, 'schedules_test']);
