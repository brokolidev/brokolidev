<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SlackController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Promise;

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
    Route::get('/articles/{article}', 'show')->name('article.show');
});

Route::get('/get_stressed', function(){

    $client = new GuzzleHttp\Client();

    $url = '';

    $keywords = [
        '치즈', '고추가루국내산', '싱그런다용도봉투(중)/검정', '양배추', '스트링', '냉면', '수입양상추', '레프리노', '피자소스',
        '키친아트독일행주(부직포)', '깍뚜기', '휘핑크림', '가는대나무이쑤시개', '알밥단무지', '유진쌀소쿠리2호', '일가집알밥단무지', '물류창고',
        '키친프리이중탕기(특소)', '피클', '버팔로윙', '메추리알', '메츄리알', '계란', '중국당면', '고추맛기름', '타코', '절단동태', '포기',
        '김밥김', '김밥', '감밥', '감밥김', '죽용기', '왕새우', '헤쉬브라운', '김치', '레이', '칼로스', '식용유18', '식용유', '바닐라시럽',
        '시아스핫바베큐', '시아스', '퓨어', '치킨바베큐토핑', '해동지', '마요네즈', '깨소금', '다진마늘', '튜립', '양파', '당근', '스팸1.81', '스팸',
        '크노르', '우동다시', '떡볶이밀키트', '탑마트', '서원유통', '배추김치국산', '코다노치즈', '닭껍질', '배추김치', '퓨어올리브', '고구마튀김', '김치전',
        '김치번', '항정', '야채튀김', '감자말이새우', '버터', '무', '검정봉투', '감자탕', '파프리카', '청수다시', '우스타', '콜라', '북어', '북어국',
        '계피', '수입김치', '빵가루', '우유튀김', '백숙재료', '브로커리', '깐메추리알', '진미채', '대상튀김가루', '대상치즈떡', '쌀', '크린장갑',
    ];

    $params = [
        'headers' => [
            'X-Requested-With' => 'XMLHttpRequest',
        ],
        'form_params' => [
            'key' => '짜사이',
            'size' => '80',
            'order' => 'recommend',
            'delivery_type' => '1',
            'area_id' => '2',
            'is_direct' => 'on',
            'page' => 0,
        ]
    ];

    $promises = [];

    for($i = 0; $i <= 20; $i++) {
        $params['form_params']['key'] = $keywords[rand(0, count($keywords) - 1)];
        $promises["st{$i}"] = $client->postAsync($url, $params);
    }

    // $responses = Promise\Utils::unwrap($promises);
    $responses = Promise\Utils::settle($promises)->wait();

    foreach ($responses as $res) {
        if($res['state'] === 'fulfilled'){
            dump($res['value']->getBody()->getContents());
        }
    }
});
