<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = [
            [
                'id'               => 1,
                'comp_name'        => 'Polock Group',
                'comp_address'     => 'banani',
                'contact_no'       => '017xxxxxx',
                'user_id'          => 1,
            ],
        ];
        Company::insert($company);

    }
}
