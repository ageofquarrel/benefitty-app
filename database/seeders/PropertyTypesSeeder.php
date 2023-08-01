<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_types')->insert(
            [
                [
                    'name' => 'Покупка'
                ],
                [
                    'name' => 'Аренда'
                ]
            ]
        );
    }
}
