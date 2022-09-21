<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SlackController;
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

Route::get('/slack/recommend-menu/{chatId}', [SlackController::class, 'sendLunchMenuMessage']);

Route::get('/memory-game', function () {
    return view('samples.memory-game');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

/**
 * Articles
 */
Route::controller(ArticleController::class)->group(function () {
    Route::get('/articles', 'index');
});
