<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'id'    => 1,
                'company_title' => 'Polock Group',
                'company_email' => 'polock@gmail.com',
                'company_phone' => '01xxxxxxxx',
                'company_address' => 'banani',
                'prefix' => 'PG',
                'developed_by' => 'Admin',
            ]
        ];

        Settings::insert($settings);
    }
}
