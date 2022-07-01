<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agents')->insert(array(
            array('id' => '1','name' => 'Adelia Howe','mobile' => '8200713200','fcmid' => NULL,'status' => '1','created_at' => '2022-05-21 06:41:53','updated_at' => '2022-05-21 06:41:53'),
            array('id' => '2','name' => 'Mr. Colin Bradtke DDS','mobile' => '9925479018','fcmid' => NULL,'status' => '0','created_at' => '2022-05-21 06:41:53','updated_at' => '2022-05-21 06:41:53')
          ));
    }
}
