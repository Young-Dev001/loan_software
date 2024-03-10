<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define sample settings data
        $settings = [
            [
                'key' => 'Blue Capital',
                'value' => 'Asset Financing App',
            ],
        ];

        // Insert data into the settings table
        foreach ($settings as $setting) {
            DB::table('settings')->insert($setting);
        }
    }
}
