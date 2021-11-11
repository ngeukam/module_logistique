<?php

use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('countries')->delete();

        \DB::table('countries')->insert(array (

            0 =>
                array (
                    'id' => 1,
                    'country_code' => 'CM',
                    'country_name' => 'Cameroon',
                    'created_at' => '2019-08-30 16:39:28',
                    'updated_at' => '2019-10-15 18:03:14',
                ),
            1 =>
                array (
                    'id' => 2,
                    'country_code' => 'CI',
                    'country_name' => 'Ivory Coast',
                    'created_at' => '2019-08-30 16:39:28',
                    'updated_at' => '2019-10-15 18:03:14',
                )
        ));
    }
}
