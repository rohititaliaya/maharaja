<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Routes;
use App\Models\DatePrice;
use App\Models\Agent;
use App\Models\Bus;
use DateInterval;
use DateTime;
use DatePeriod;
use DB;

class DateCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // * * * * * php /home/rohit/Desktop/busbook schedule:run >> /dev/null 2>&1
        \Log::info("Cron is working fine! and cron started");
        /**
         * routes by agents
         * 
         * */

        //------- counting date and gap ------//   
        $begin = Carbon::now()->format('d-M-Y');
        $end = Date('d-M-Y', strtotime('+30 days')); 
        $date_range = $this->getDatesFromRange($begin,$end);
        // \Log::info(json_encode($date_range));

        // ------------ getting agent chunck
        $agents = Agent::all()->pluck('id')->toArray();
        $array = array_chunk($agents, 10);

        $count = 0;
        foreach ($array[0] as $key => $value) {
            
            \Log::info('round '.$count++);

            $buses_id = Bus::where('agent_id',$value)->pluck('id')->toArray();
            $routes = Routes::whereIn('bus_id',$buses_id)->get();
            foreach ($routes as $key => $value) {
                $routeid = $value->id; 
                $dep = $value->price;
                $date_price = DatePrice::where('route_id', $routeid)->get();
                $date_array1 =[];
                if (count($date_price)) {
                    foreach ($date_price as $json) {
                        // \Log::info(json_encode($json));
                        $d1 = Carbon::createFromFormat('d-M-Y', $begin);
                        $d2 = Carbon::createFromFormat('d-M-Y', $json->date);
                        if ($d1->gt($d2)) {
                            $date_price = DatePrice::find($json->id)->where('date',$json->date)->first();
                            $date_price->delete();
                            // \Log::info('delete here');
                        }else{
                            $date_array1[$json->date] = $json->price;
                            // \Log::info('add here');
                        }
                    }
                    $date_array =[];
                    foreach ($date_range as $dt) {
                        if (!array_key_exists($dt, $date_array1)) {
                            $date_array[$dt] = $dep;
                            // \Log::info('new array---------');
                        }
                    }
                    \Log::info($date_array);  
                    foreach ($date_array as $xdt => $pv) {
                        $datep = new DatePrice();
                        $datep->date = $xdt;
                        $datep->price = $pv;
                        $datep->route_id = $routeid;
                        $datep->save();
                    }
                    // \Log::info($routeid);
                }
            }
        }
        \Log::info("Cron is working fine! and cron ended");

    }

    // Function to get all the dates in given range
    function getDatesFromRange($start, $end, $format = 'd-M-Y') {
        
        $array = array();
        $interval = new DateInterval('P1D');
    
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
    
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
   
        foreach($period as $date) {                 
            $array[] = $date->format($format); 
        }
        return $array;
    }
}
