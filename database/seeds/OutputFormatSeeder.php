<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutputFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('output_formats')->insert([[
            'format' => '.las'
        ], [
            'format' => '.laz'
        ], [
            'format' => '.xyz'
        ], [
            'format' => '.txt'
        ], [
            'format' => '.dwg'
        ], [
            'format' => '.dgn'
        ], [
            'format' => '.dm'
        ], [
            'format' => '.shp'
        ], [
            'format' => '.pdf'
        ], [
            'format' => '.dxf'
        ], [
            'format' => '.sima'
        ], [
            'format' => '.tif'
        ], [
            'format' => '.tiff'
        ], [
            'format' => '.jpeg'
        ], [
            'format' => '.kml'
        ], [
            'format' => '.csv'
        ], [
            'format' => '.xlsx'
        ]]);
    }
}
