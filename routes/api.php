<?php

use App\Http\Controllers\SlackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/slack/response/recommend-menu', [SlackController::class, 'respondWithMenu']);

Route::post('/test', function(Request $request){
    return response()->json(['message' => 'error message'], 500);
});

Route::post('/400error', function(Request $request){
    return response()->json(['message' => '400 Error'], 400);
});
