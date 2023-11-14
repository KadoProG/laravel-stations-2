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

// GET /practiceでpracticeという文字列を返す
Route::get('practice', function() {
    return response('practice');
});

// GET /practice2でpractice2という文字列を、変数を用いて返すこと
Route::get('practice2', function() {
    $test = 'practice2';
    return response($test);
});

// /practice3とアクセスすると、testという文字列が返ってくるようにページを作成
Route::get('practice3', function() {
    $test = 'test';
    return response($test);
});