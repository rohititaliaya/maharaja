<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePickupPointsRequest;
use App\Http\Requests\UpdatePickupPointsRequest;
use App\Models\PickupPoints;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Bus;
use App\Models\Routes;
use DB;

class PickupPointsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    
    public function getPickupPoints()
    {
       
        if (request()->agent_id) {
            $buses = Bus::where('agent_id',request()->agent_id)->where('status','A')->pluck('id')->toArray();
            $buses_city = Bus::where('agent_id',request()->agent_id)->where('status','A')->select(['id','travels_name','plat_no'])->get();
            $routes = Routes::whereIn('bus_id',$buses)->select('from','bus_id')->get();
            foreach ($buses_city as $key => $value) {
               foreach($routes as $frm){
                   if($value->id == $frm['bus_id']){
                       $buses_city[$key]->cities = $frm['from'];
                   }
               }
            }
            return response()->json(['flag'=>true ,'data'=>$buses_city]);
        }

    }

    public function getpoints()
    {
        if (request()->bus_id && request()->city_id) {
            $routes = PickupPoints::where('bus_id',request()->bus_id)->where('from',request()->city_id)->get('pickup_points');
            if (is_null($routes)) {
                return response()->json(['flag'=>false ,'data'=>"no data found"]);
            }
            return response()->json(['flag'=>true ,'data'=>$routes]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePickupPointsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PickupPoints  $pickupPoints
     * @return \Illuminate\Http\Response
     */
    public function show(PickupPoints $pickupPoints)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PickupPoints  $pickupPoints
     * @return \Illuminate\Http\Response
     */
    public function edit(PickupPoints $pickupPoints)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePickupPointsRequest  $request
     * @param  \App\Models\PickupPoints  $pickupPoints
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $agent_id = $request->agent_id;
        $bus_id = $request->bus_id;
        $from_city_id =$request->city_id;

        $pickupPoints = PickupPoints::where('bus_id',$bus_id)->where('from',$from_city_id)->first();
        if (!is_null($pickupPoints)) {
            $pickupPoints->pickup_points = json_encode($request->pickup_points);
         
            $pickupPoints->last_pick = $request->pickup_points[0]['time'];
            $pickupPoints->save();
            return response()->json(['flag'=>true, 'message'=>'successfully updated', 'data'=>$pickupPoints]);
        }else{
            $pickupPoints = new PickupPoints();
            $pickupPoints->bus_id = $request->bus_id;
            $pickupPoints->from = $request->city_id;
            $pickupPoints->pickup_points = json_encode($request->pickup_points);
           
            $pickupPoints->last_pick = $request->pickup_points[0]['time'];
            $pickupPoints->save();
        }
        return response()->json(['flag'=>true,'message'=>'record updated','data'=>$pickupPoints]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PickupPoints  $pickupPoints
     * @return \Illuminate\Http\Response
     */
    public function destroy(PickupPoints $pickupPoints)
    {
        //
    }
}
    