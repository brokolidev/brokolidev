<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            "해장국",
            "칼국수",
            "우육탕면",
            "평양냉면",
            "감자탕",
            "돼지국밥",
            "순대국",
            "햄버거",
            "돈까스",
            "초밥",
            "구내식당",
            "쌀국수",
            "짜장면",
            "짬뽕",
            "볶음밥",
            "탄탄면",
            "수제비",
            "함흥냉면",
            "라면에김밥",
            "순두부찌개",
            "김치찌개",
            "제육볶음",
            "스테이크",
            "피자",
            "파스타"
        ];

        foreach ($menus as $menu) {
            DB::table('menus')->insert([
                'name' => $menu,
                'is_picked' => false,
                'picked_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
