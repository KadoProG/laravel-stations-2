<?php

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

// Route::get('URL', [Controllerの名前::class, 'Controller内のfunction名']);
Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3', [PracticeController::class, 'sample3']);
Route::get('/getPractice', [PracticeController::class, 'getPractice']);

Route::get('/movies', [MovieController::class, 'movies']);
Route::get('/movies/{id}', [MovieController::class, 'movie_detail']);
Route::get('/admin/movies', [MovieController::class, 'movie_admin']);
Route::get('/admin/movies/create', [MovieController::class, 'movies_create']);
Route::post('/admin/movies/store', [MovieController::class, 'movies_store']);
Route::get('/admin/movies/{id}/edit', [MovieController::class, 'movies_edit']);
Route::get('/admin/movies/{id}', [MovieController::class, 'movie_detail']);
Route::patch('/admin/movies/{id}/update', [MovieController::class, 'movies_update']);
Route::delete('/admin/movies/{id}/destroy', [MovieController::class, 'movies_delete']);

Route::get('/sheets', [MovieController::class, 'sheets_get']);

// デバッグ用
Route::get('/test/genre', [MovieController::class, 'genres_preview']);
Route::get('/test/movie', [MovieController::class, 'movies_preview']);
Route::get('/test/sheet', [MovieController::class, 'sheets_preview']);
Route::get('/test/schedule', [MovieController::class, 'schedules_preview']);
Route::get('/test/scheduleTest', [MovieController::class, 'schedules_test']);
