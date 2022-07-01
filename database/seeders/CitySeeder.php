<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert(
            array(
                array('id' => '306','name' => 'Ahmadabad','created_at' => NULL,'updated_at' => NULL),
                array('id' => '307','name' => 'Amreli','created_at' => NULL,'updated_at' => NULL),
                array('id' => '308','name' => 'Anand','created_at' => NULL,'updated_at' => NULL),
                array('id' => '309','name' => 'Anjar','created_at' => NULL,'updated_at' => NULL),
                array('id' => '310','name' => 'Bardoli','created_at' => NULL,'updated_at' => NULL),
                array('id' => '311','name' => 'Bharuch','created_at' => NULL,'updated_at' => NULL),
                array('id' => '312','name' => 'Bhavnagar','created_at' => NULL,'updated_at' => NULL),
                array('id' => '313','name' => 'Bhuj','created_at' => NULL,'updated_at' => NULL),
                array('id' => '314','name' => 'Borsad','created_at' => NULL,'updated_at' => NULL),
                array('id' => '315','name' => 'Botad','created_at' => NULL,'updated_at' => NULL),
                array('id' => '316','name' => 'Chandkheda','created_at' => NULL,'updated_at' => NULL),
                array('id' => '317','name' => 'Chandlodiya','created_at' => NULL,'updated_at' => NULL),
                array('id' => '318','name' => 'Dabhoi','created_at' => NULL,'updated_at' => NULL),
                array('id' => '319','name' => 'Dahod','created_at' => NULL,'updated_at' => NULL),
                array('id' => '320','name' => 'Dholka','created_at' => NULL,'updated_at' => NULL),
                array('id' => '321','name' => 'Dhoraji','created_at' => NULL,'updated_at' => NULL),
                array('id' => '322','name' => 'Dhrangadhra','created_at' => NULL,'updated_at' => NULL),
                array('id' => '323','name' => 'Disa','created_at' => NULL,'updated_at' => NULL),
                array('id' => '324','name' => 'Gandhidham','created_at' => NULL,'updated_at' => NULL),
                array('id' => '325','name' => 'Gandhinagar','created_at' => NULL,'updated_at' => NULL),
                array('id' => '326','name' => 'Ghatlodiya','created_at' => NULL,'updated_at' => NULL),
                array('id' => '327','name' => 'Godhra','created_at' => NULL,'updated_at' => NULL),
                array('id' => '328','name' => 'Gondal','created_at' => NULL,'updated_at' => NULL),
                array('id' => '329','name' => 'Himatnagar','created_at' => NULL,'updated_at' => NULL),
                array('id' => '330','name' => 'Jamnagar','created_at' => NULL,'updated_at' => NULL),
                array('id' => '331','name' => 'Jamnagar','created_at' => NULL,'updated_at' => NULL),
                array('id' => '332','name' => 'Jetpur','created_at' => NULL,'updated_at' => NULL),
                array('id' => '333','name' => 'Junagadh','created_at' => NULL,'updated_at' => NULL),
                array('id' => '334','name' => 'Kalol','created_at' => NULL,'updated_at' => NULL),
                array('id' => '335','name' => 'Keshod','created_at' => NULL,'updated_at' => NULL),
                array('id' => '336','name' => 'Khambhat','created_at' => NULL,'updated_at' => NULL),
                array('id' => '337','name' => 'Kundla','created_at' => NULL,'updated_at' => NULL),
                array('id' => '338','name' => 'Mahuva','created_at' => NULL,'updated_at' => NULL),
                array('id' => '339','name' => 'Mangrol','created_at' => NULL,'updated_at' => NULL),
                array('id' => '340','name' => 'Modasa','created_at' => NULL,'updated_at' => NULL),
                array('id' => '341','name' => 'Morvi','created_at' => NULL,'updated_at' => NULL),
                array('id' => '342','name' => 'Nadiad','created_at' => NULL,'updated_at' => NULL),
                array('id' => '343','name' => 'Navagam Ghed','created_at' => NULL,'updated_at' => NULL),
                array('id' => '344','name' => 'Navsari','created_at' => NULL,'updated_at' => NULL),
                array('id' => '345','name' => 'Palitana','created_at' => NULL,'updated_at' => NULL),
                array('id' => '346','name' => 'Patan','created_at' => NULL,'updated_at' => NULL),
                array('id' => '347','name' => 'Porbandar','created_at' => NULL,'updated_at' => NULL),
                array('id' => '348','name' => 'Puna','created_at' => NULL,'updated_at' => NULL),
                array('id' => '349','name' => 'Rajkot','created_at' => NULL,'updated_at' => NULL),
                array('id' => '350','name' => 'Ramod','created_at' => NULL,'updated_at' => NULL),
                array('id' => '351','name' => 'Ranip','created_at' => NULL,'updated_at' => NULL),
                array('id' => '352','name' => 'Siddhapur','created_at' => NULL,'updated_at' => NULL),
                array('id' => '353','name' => 'Sihor','created_at' => NULL,'updated_at' => NULL),
                array('id' => '354','name' => 'Surat','created_at' => NULL,'updated_at' => NULL),
                array('id' => '355','name' => 'Surendranagar','created_at' => NULL,'updated_at' => NULL),
                array('id' => '356','name' => 'Thaltej','created_at' => NULL,'updated_at' => NULL),
                array('id' => '357','name' => 'Una','created_at' => NULL,'updated_at' => NULL),
                array('id' => '358','name' => 'Unjha','created_at' => NULL,'updated_at' => NULL),
                array('id' => '359','name' => 'Upleta','created_at' => NULL,'updated_at' => NULL),
                array('id' => '360','name' => 'Vadodara','created_at' => NULL,'updated_at' => NULL),
                array('id' => '361','name' => 'Valsad','created_at' => NULL,'updated_at' => NULL),
                array('id' => '362','name' => 'Vapi','created_at' => NULL,'updated_at' => NULL),
                array('id' => '363','name' => 'Vastral','created_at' => NULL,'updated_at' => NULL),
                array('id' => '364','name' => 'Vejalpur','created_at' => NULL,'updated_at' => NULL),
                array('id' => '365','name' => 'Veraval','created_at' => NULL,'updated_at' => NULL),
                array('id' => '366','name' => 'Vijalpor','created_at' => NULL,'updated_at' => NULL),
                array('id' => '367','name' => 'Visnagar','created_at' => NULL,'updated_at' => NULL),
                array('id' => '368','name' => 'Wadhwan','created_at' => NULL,'updated_at' => NULL)
              )
        );
    }
}
