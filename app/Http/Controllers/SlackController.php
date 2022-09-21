<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SlackController extends Controller
{
    public array $menus = [
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

    public function sendLunchMenuMessage(string $chatId): void
    {
        $pickedMenu = $this->recommendMenu();

        $responseMessage = [
            'channel' => $chatId, // 식봄개발팀
            'text' => "점심시간이 다가옵니다! 콜리봇이 추천하는 오늘의 메뉴는 >>> {$pickedMenu}",
        ];

        Http::withToken(env('SLACK_BOT_TOKEN'))
            ->withBody(json_encode($responseMessage), 'application/json')
            ->post('https://slack.com/api/chat.postMessage');
    }

    public function respondWithMenu(Request $request): void
    {
        $requester = $request->input('user_name');
        $responseUrl = $request->input('response_url');

        $pickedMenu = $this->recommendMenu();

        $responseMessage = [
            'text' => "안녕하세요! {$requester}님, 오늘은 {$pickedMenu} 어때요?",
        ];

        Http::withBody(json_encode($responseMessage), 'application/json')
            ->post($responseUrl);
    }

    private function recommendMenu(): string
    {
        $pickedKey = array_rand($this->menus);

        return $this->menus[$pickedKey];
    }
}
