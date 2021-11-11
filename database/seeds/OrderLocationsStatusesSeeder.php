<?php

use Illuminate\Database\Seeder;

class OrderLocationsStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('order_locations_statuses')->delete();

        \DB::table('order_locations_statuses')->insert(array (

            0 =>
                array (
                    'id' => 1,
                    'locations_status' => 'Waiting to load',
                    'created_at' => '2019-08-30 16:39:28',
                    'updated_at' => '2019-10-15 18:03:14',
                ),
            1 =>
                array (
                    'id' => 2,
                    'locations_status' => 'Pickup',
                    'created_at' => '2019-08-30 16:39:28',
                    'updated_at' => '2019-10-15 18:03:14',
                ),
            2 =>
                array (
                    'id' => 3,
                    'locations_status' => 'Transit',
                    'created_at' => '2019-10-15 18:03:50',
                    'updated_at' => '2019-10-15 18:03:50',
                ),
            3 =>
                array (
                    'id' => 4,
                    'locations_status' => 'Arrived',
                    'created_at' => '2019-10-15 18:04:30',
                    'updated_at' => '2019-10-15 18:04:30',
                ),
            4 =>
                array (
                    'id' => 5,
                    'locations_status' => 'Reception',
                    'created_at' => '2019-10-15 18:04:13',
                    'updated_at' => '2019-10-15 18:04:13',
                ),
            5 =>
                array (
                    'id' => 6,
                    'locations_status' => 'Destination',
                    'created_at' => '2019-10-15 18:04:30',
                    'updated_at' => '2019-10-15 18:04:30',
                ),
        ));
    }
}
