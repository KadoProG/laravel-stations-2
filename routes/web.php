<?php

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

// Route::get('URL', [Controllerの名前::class, 'Controller内のfunction名']);
Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3', [PracticeController::class, 'sample3']);
Route::get('/getPractice', [PracticeController::class, 'getPractice']);
Route::get('/movies', [PracticeController::class, 'movies']);
Route::get('/movies/{id}', [PracticeController::class, 'movie_detail']);
Route::get('/admin', [PracticeController::class, 'movies']);
Route::get('/admin/movies', [PracticeController::class, 'movie_admin']);
Route::get('/admin/movies/create', [PracticeController::class, 'movies_create']);
Route::post('/admin/movies/store', [PracticeController::class, 'movies_store']);
Route::get('/admin/movies/{id}/edit', [PracticeController::class, 'movies_edit']);
Route::get('/admin/movies/{id}', [PracticeController::class, 'movie_detail']);
Route::patch('/admin/movies/{id}/update', [PracticeController::class, 'movies_update']);
Route::delete('/admin/movies/{id}/destroy', [PracticeController::class, 'movies_delete']);

Route::get('/sheets', [PracticeController::class, 'sheets_get']);

// デバッグ用
Route::get('/test/genre', [PracticeController::class, 'genres_preview']);
Route::get('/test/movie', [PracticeController::class, 'movies_preview']);
Route::get('/test/sheet', [PracticeController::class, 'sheets_preview']);
Route::get('/test/schedule', [PracticeController::class, 'schedules_preview']);
Route::get('/test/scheduleTest', [PracticeController::class, 'schedules_test']);
