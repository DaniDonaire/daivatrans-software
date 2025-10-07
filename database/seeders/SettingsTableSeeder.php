<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            ['key' => 'app_name', 'value' => '', 'type' => 'text'],
            ['key' => 'favicon', 'value' => '', 'type' => 'file'],
            ['key' => 'logo_rectangular', 'value' => '', 'type' => 'file'],
            ['key' => 'logo_square', 'value' => '', 'type' => 'file'],
        ]);
    }
}
