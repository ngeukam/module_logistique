<?php

use Illuminate\Database\Seeder;

class TruckTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('trucks')->delete();

        \DB::table('trucks')->insert(array (

             0=>
                array (
                    'id' => 1,
                    'type_truck' => 'Camion fourgon',
                    'created_at' => '2019-08-30 16:39:28',
                    'updated_at' => '2019-10-15 18:03:14',
                ),
            1 =>
                array (
                    'id' => 2,
                    'type_truck' => 'Camion frigorifique',
                    'created_at' => '2019-08-30 16:39:28',
                    'updated_at' => '2019-10-15 18:03:14',
                ),
            2 =>
                array (
                    'id' => 3,
                    'type_truck' => 'Camion benne',
                    'created_at' => '2019-08-30 16:39:28',
                    'updated_at' => '2019-10-15 18:03:14',
                ),
            3 =>
                array (
                    'id' => 4,
                    'type_truck' => 'Camion citerne',
                    'created_at' => '2019-08-30 16:39:28',
                    'updated_at' => '2019-10-15 18:03:14',
                ),
            4 =>
                array (
                    'id' => 5,
                    'type_truck' => 'Camion en carosserie',
                    'created_at' => '2019-08-30 16:39:28',
                    'updated_at' => '2019-10-15 18:03:14',
                ),
            5 =>
                array (
                    'id' => 6,
                    'type_truck' => 'Camion calabrese',
                    'created_at' => '2019-08-30 16:39:28',
                    'updated_at' => '2019-10-15 18:03:14',
                ),
            6 =>
                array (
                    'id' => 7,
                    'type_truck' => 'Camion plateau',
                    'created_at' => '2019-08-30 16:39:28',
                    'updated_at' => '2019-10-15 18:03:14',
                ),
            7 =>
                array (
                    'id' => 8,
                    'type_truck' => 'Camion porte char',
                    'created_at' => '2019-08-30 16:39:28',
                    'updated_at' => '2019-10-15 18:03:14',
                ),
            8 =>
                array (
                    'id' => 9,
                    'type_truck' => 'Camion betaillére',
                    'created_at' => '2019-08-30 16:39:28',
                    'updated_at' => '2019-10-15 18:03:14',
                ),
        ));
    }
}
