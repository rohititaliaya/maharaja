<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RoutesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('routes')->insert(
            array(
                array('id' => '2','bus_id' => '6','from' => '312','to' => '306','price'=>900,'default_price' => '[{"date":"05\\/12\\/2022","price":500},{"date":"06\\/12\\/2022","price":600},{"date":"07\\/12\\/2022","price":700}]','status' => 'A','created_at' => '2022-05-21 13:11:57','updated_at' => '2022-05-21 13:11:57'),
                array('id' => '3','bus_id' => '1','from' => '312','to' => '306','price'=>900,'default_price' => '[{"date":"05\\/12\\/2022","price":500},{"date":"06\\/12\\/2022","price":600},{"date":"07\\/12\\/2022","price":700}]','status' => 'A','created_at' => '2022-05-21 13:20:06','updated_at' => '2022-05-21 13:20:06'),
                array('id' => '4','bus_id' => '2','from' => '312','to' => '306','price'=>900,'default_price' => '[{"date":"05\\/12\\/2022","price":500},{"date":"06\\/12\\/2022","price":600},{"date":"07\\/12\\/2022","price":700}]','status' => 'A','created_at' => '2022-05-21 13:20:17','updated_at' => '2022-05-21 13:20:17'),
                array('id' => '5','bus_id' => '3','from' => '312','to' => '306','price'=>900,'default_price' => '[{"date":"05\\/12\\/2022","price":500},{"date":"06\\/12\\/2022","price":600},{"date":"07\\/12\\/2022","price":700}]','status' => 'A','created_at' => '2022-05-21 13:20:23','updated_at' => '2022-05-21 13:20:23'),
                array('id' => '6','bus_id' => '4','from' => '312','to' => '306','price'=>900,'default_price' => '[{"date":"05\\/12\\/2022","price":500},{"date":"06\\/12\\/2022","price":600},{"date":"07\\/12\\/2022","price":700}]','status' => 'A','created_at' => '2022-05-21 13:20:31','updated_at' => '2022-05-21 13:20:31'),
                array('id' => '7','bus_id' => '5','from' => '312','to' => '306','price'=>900,'default_price' => '[{"date":"05\\/12\\/2022","price":500},{"date":"06\\/12\\/2022","price":600},{"date":"07\\/12\\/2022","price":700}]','status' => 'A','created_at' => '2022-05-21 13:20:36','updated_at' => '2022-05-21 13:20:36'),
                array('id' => '1','bus_id' => '6','from' => '312','to' => '306','price'=>900,'default_price' => '[{"date":"05\\/12\\/2022","price":500},{"date":"06\\/12\\/2022","price":600},{"date":"07\\/12\\/2022","price":700}]','status' => 'A','created_at' => '2022-05-21 13:08:57','updated_at' => '2022-05-21 13:08:57')
            )
        );
    }
}
