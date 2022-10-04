<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SlackController extends Controller
{

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

    public function recommendMenu(): string
    {
        if(date('N') === '1') {
            return Menu::picked()->update(['is_picked' => false]);
        }

        $pickedMenu = Menu::where('is_picked', false)->get()->random();

        // picked count && weekly picked update
        $pickedMenu->picked_count++;
        $pickedMenu->is_picked = true;
        $pickedMenu->save();

        return $pickedMenu->name;
    }
}
