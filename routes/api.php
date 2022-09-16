<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

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

Route::post('/slack/recommend-menu', function(Request $request) {
    $requester = $request->input('user_name');
    $response_url = $request->input('response_url');

    $menus = [
        '은희네 해장국',
        '삼미 칼국수',
        '우육면',
        '봉피양 평양냉면',
        '일미 감자탕',
        '달맞이국밥',
        '미쁜선순대',
        '바스버거',
        '서호돈까스',
        '네코부루 일본식 돈까스',
    ];

    $picked_key = array_rand($menus);

    $response_message = [
        "text" => "안녕하세요! {$requester}님, 오늘은 {$menus[$picked_key]} 어때요?",
    ];

    Http::withBody(json_encode($response_message), 'application/json')
                    ->post($response_url);
});
