<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkOutputFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('work_output_formats')->insert([[
            'work_id' => 1,
            'output_format_id' => 1,
        ],[
            'work_id' => 1,
            'output_format_id' => 2,
        ],[
            'work_id' => 1,
            'output_format_id' => 3,
        ],[
            'work_id' => 1,
            'output_format_id' => 4,
        ],[
            'work_id' => 2,
            'output_format_id' => 5,
        ],[
            'work_id' => 2,
            'output_format_id' => 6,
        ],[
            'work_id' => 2,
            'output_format_id' => 7,
        ],[
            'work_id' => 2,
            'output_format_id' => 8,
        ],[
            'work_id' => 2,
            'output_format_id' => 9,
        ],[
            'work_id' => 3,
            'output_format_id' => 10,
        ],[
            'work_id' => 3,
            'output_format_id' => 5,
        ],[
            'work_id' => 3,
            'output_format_id' => 8,
        ],[
            'work_id' => 3,
            'output_format_id' => 9,
        ],[
            'work_id' => 4,
            'output_format_id' => 10,
        ],[
            'work_id' => 4,
            'output_format_id' => 5,
        ],[
            'work_id' => 4,
            'output_format_id' => 11,
        ],[
            'work_id' => 5,
            'output_format_id' => 12,
        ],[
            'work_id' => 5,
            'output_format_id' => 13,
        ],[
            'work_id' => 5,
            'output_format_id' => 14,
        ],[
            'work_id' => 5,
            'output_format_id' => 15,
        ],[
            'work_id' => 6,
            'output_format_id' => 16,
        ],[
            'work_id' => 7,
            'output_format_id' => 17,
        ],[
            'work_id' => 8,
            'output_format_id' => 17,
        ],]);
    }
}
