<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('works')->insert([[
            'work' => 'グラウンドデータ'
        ], [
            'work' => '簡易図化'
        ], [
            'work' => '等高線データ'
        ], [
            'work' => '縦横断図'
        ], [
            'work' => '簡易デジタルオルソフォト'
        ], [
            'work' => '土量計算(メッシュ法)'
        ], [
            'work' => '簡易精度管理表'
        ], [
            'work' => '公共精度管理表'
        ]]);
    }
}
