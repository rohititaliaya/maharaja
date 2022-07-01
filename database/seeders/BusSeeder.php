<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buses')->insert(array(
            array('id' => '1','travels_name' => 'Raghav','seats_avail'=>38,'image' => '/public/images/default-bus.webp','agent_id' => '1','status' => 'A','created_at' => '2022-05-21 01:23:40','updated_at' => '2022-05-21 01:23:40'),
            array('id' => '2','travels_name' => 'Mahasagar','seats_avail'=>38,'image' => '/public/images/default-bus.webp','agent_id' => '1','status' => 'A','created_at' => '2022-05-21 01:24:52','updated_at' => '2022-05-21 01:24:52'),
            array('id' => '3','travels_name' => 'Santkrupa','seats_avail'=>38,'image' => '/public/images/default-bus.webp','agent_id' => '1','status' => 'A','created_at' => '2022-05-21 09:52:02','updated_at' => '2022-05-21 09:52:02'),
            array('id' => '4','travels_name' => 'Gurukrupa','seats_avail'=>38,'image' => '/public/images/default-bus.webp','agent_id' => '2','status' => 'A','created_at' => '2022-05-21 10:08:42','updated_at' => '2022-05-21 10:08:42'),
            array('id' => '5','travels_name' => 'SantChaya','seats_avail'=>38,'image' => '/public/images/default-bus.webp','agent_id' => '2','status' => 'A','created_at' => '2022-05-21 11:48:06','updated_at' => '2022-05-21 11:48:06'),
            array('id' => '6','travels_name' => 'SaiDarshan','seats_avail'=>38,'image' => '/public/images/default-bus.webp','agent_id' => '2','status' => 'A','created_at' => '2022-05-21 12:41:18','updated_at' => '2022-05-21 12:41:18')
        ));
    }
}
