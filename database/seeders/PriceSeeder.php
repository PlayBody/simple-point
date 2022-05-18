<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('prices')->insert([[
            'work_id' => 1,
            'main_amount' => 3200,
            'main_unit' => '円/ha',
            'add_amount' => 29800,
            'add_unit' => '円/~10ha',
            'main_period' => 5,
            'main_period_unit' => '営業日/~20ha',
            'add_period' => 1,
            'add_period_unit' => '営業日/10ha',
        ], [
            'work_id' => 2,
            'main_amount' => 8500,
            'main_unit' => '円/ha',
            'add_amount' => 800000,
            'add_unit' => '円/~1ha',
            'main_period' => 20,
            'main_period_unit' => '営業日/50ha',
            'add_period' => null,
            'add_period_unit' => null,
        ], [
            'work_id' => 3,
            'main_amount' => 2300,
            'main_unit' => '円/ha',
            'add_amount' => null,
            'add_unit' => null,
            'main_period' => 5,
            'main_period_unit' => '営業日/~20ha',
            'add_period' => 1,
            'add_period_unit' => '営業日/10ha',
        ], [
            'work_id' => 4,
            'main_amount' => 8000,
            'main_unit' => '円/本',
            'add_amount' => null,
            'add_unit' => null,
            'main_period' => 2,
            'main_period_unit' => '営業日/40本',
            'add_period' => null,
            'add_period_unit' => null,
        ], [
            'work_id' => 5,
            'main_amount' => 50000,
            'main_unit' => '円/式',
            'add_amount' => null,
            'add_unit' => null,
            'main_period' => 4,
            'main_period_unit' => '営業日/式',
            'add_period' => null,
            'add_period_unit' => null,
        ], [
            'work_id' => 6,
            'main_amount' => 10000,
            'main_unit' => '円/式',
            'add_amount' => null,
            'add_unit' => null,
            'main_period' => 2,
            'main_period_unit' => '営業日/式',
            'add_period' => null,
            'add_period_unit' => null,
        ], [
            'work_id' => 7,
            'main_amount' => 70000,
            'main_unit' => '円/式',
            'add_amount' => null,
            'add_unit' => null,
            'main_period' => 5,
            'main_period_unit' => '営業日/式',
            'add_period' => null,
            'add_period_unit' => null,
        ], [
            'work_id' => 8,
            'main_amount' => 120000,
            'main_unit' => '円/式',
            'add_amount' => null,
            'add_unit' => null,
            'main_period' => 10,
            'main_period_unit' => '営業日/式',
            'add_period' => null,
            'add_period_unit' => null,
        ]]);
    }
}
