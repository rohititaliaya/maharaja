<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seats')->insert(array(
            array(
                "id"=>1,
                "isSelected"=> false,
                "seatNo"=> "A",
                "type"=>'lower'
            ),
            array(
                "id"=>2,
                "isSelected"=> false,
                "seatNo"=> "D",
                "type"=>'lower'
            ),
            array(
                "id"=>3,
                "isSelected"=> false,
                "seatNo"=> "E",
                "type"=>'lower'
            ),
            array(
                "id"=>4,
                "isSelected"=> false,
                "seatNo"=> "H",
                "type"=>'lower'
            ),
            array(
                "id"=>5,
                "isSelected"=> false,
                "seatNo"=> "I",
                "type"=>'lower'
            ),
            array(
                "id"=>6,
                "isSelected"=> false,
                "seatNo"=> "1,2",
                "type"=>'lower'
            ),
            array(
                "id"=>7,
                "isSelected"=> false,
                "seatNo"=> "7,8",
                "type"=>'lower'
            ),
            array(
                "id"=>8,
                "isSelected"=> false,
                "seatNo"=> "9,10",
                "type"=>'lower'
            ),
            array(
                "id"=>9,
                "isSelected"=> false,
                "seatNo"=> "15,16",
                "type"=>'lower'
            ),
            array(
                "id"=>10,
                "isSelected"=> false,
                "seatNo"=> "17,18",
                "type"=>'lower'
            ),
            array(
                "id"=>11,
                "isSelected"=> false,
                "seatNo"=> "23,24",
                "type"=>'lower'
            ),
            array(
                "id"=>12,
                "isSelected"=> false,
                "seatNo"=> "25,26",
                "type"=>'lower'
            ),
            array(
                "id"=>13,
                "isSelected"=> false,
                "seatNo"=> "B",
                'type'=>'upper'
            ),
            array(
                "id"=>14,
                "isSelected"=> false,
                "seatNo"=> "C",
                'type'=>'upper'
            ),
            array(
                "id"=>15,
                "isSelected"=> false,
                "seatNo"=> "F",
                'type'=>'upper'
            ),
            array(
                "id"=>16,
                "isSelected"=> false,
                "seatNo"=> "G",
                'type'=>'upper'
            ),
            array(
                "id"=>17,
                "isSelected"=> false,
                "seatNo"=> "J",
                'type'=>'upper'
            ),
            array(
                "id"=>18,
                "isSelected"=> false,
                "seatNo"=> "3,4",
                'type'=>'upper'
            ),
            array(
                "id"=>19,
                "isSelected"=> false,
                "seatNo"=> "5,6",
                'type'=>'upper'
            ),
            array(
                "id"=>20,
                "isSelected"=> false,
                "seatNo"=> "11,12",
                'type'=>'upper'
            ),
            array(
                "id"=>21,
                "isSelected"=> false,
                "seatNo"=> "13,14",
                'type'=>'upper'
            ),
            array(
                "id"=>22,
                "isSelected"=> false,
                "seatNo"=> "19,20",
                'type'=>'upper'
            ),
            array(
                "id"=>23,
                "isSelected"=> false,
                "seatNo"=> "21,22",
                'type'=>'upper'
            ),
            array(
                "id"=>24,
                "isSelected"=> false,
                "seatNo"=> "27,28",
                'type'=>'upper'
            )
        )); 
    }
}
