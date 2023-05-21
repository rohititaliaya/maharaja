<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDropPointsRequest;
use App\Http\Requests\UpdateDropPointsRequest;
use App\Models\DropPoints;
use App\Models\Bus;
use App\Models\Routes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DropPointsController extends Controller
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

    public function getDropPoints()
    {
         if (request()->agent_id) {
            $buses = Bus::where('agent_id',request()->agent_id)->where('status','A')->pluck('id')->toArray();
            $buses_city = Bus::where('agent_id',request()->agent_id)->where('status','A')->select(['id','travels_name','plat_no'])->get();
            $routes = Routes::whereIn('bus_id',$buses)->select('to','bus_id')->get();
            foreach ($buses_city as $key => $value) {
               foreach($routes as $frm){
                   if($value->id == $frm['bus_id']){
                       $buses_city[$key]->cities = $frm['to'];
                   }
               }
            }
            return response()->json(['flag'=>true ,'data'=>$buses_city]);
        }

    }

    public function getpoints()
    {
        if (request()->bus_id && request()->city_id) {
            $routes = DropPoints::where('bus_id',request()->bus_id)->where('to',request()->city_id)->get('drop_points');
            return response()->json(['flag'=>true, 'message'=>'success', 'data'=>$routes]);
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
     * @param  \App\Http\Requests\StoreDropPointsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'bus_id'=>'required',
            'from' => 'required',
            'to' => 'required',
            'drop_points' => 'required',
        ]);

        if ($validator->fails()) {
            $error = [];
            $error['flag']=false;
            $cnt = 0;
            foreach ($validator->errors()->toArray() as $key => $value) {
                $error[$cnt] = $value[0];
                $cnt++;
            }
            return response()->json($error);
        }
        try {
            $drop = new DropPoints();
            $drop->bus_id = $request->bus_id;
            $drop->from = $request->from;
            $drop->to = $request->to;
            $drop->drop_points = json_encode($request->drop_points);
            $drop->save();
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th]);
        }
        return response()->json(['flag'=>true,
            'message'=>'Record Successfully created!',
            'data'=>$drop],201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DropPoints  $dropPoints
     * @return \Illuminate\Http\Response
     */
    public function show(DropPoints $dropPoints)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DropPoints  $dropPoints
     * @return \Illuminate\Http\Response
     */
    public function edit(DropPoints $dropPoints)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDropPointsRequest  $request
     * @param  \App\Models\DropPoints  $dropPoints
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $agent_id = $request->agent_id;
        $bus_id = $request->bus_id;
        $from_city_id =$request->city_id;

        $dropPoints = DropPoints::where('bus_id',$bus_id)->where('to',$from_city_id)->first();
        if (!is_null($dropPoints)) {
            $dropPoints->drop_points = json_encode($request->drop_points);
            
            $dropPoints->last_drop = $request->drop_points[0]['time'];
            $dropPoints->save();
            return response()->json(['flag'=>true, 'message'=>'successfully updated', 'data'=>$dropPoints]);
        }else{
            $dropPoints = new DropPoints();
            $dropPoints->bus_id = $request->bus_id;
            $dropPoints->to = $request->city_id;
            $dropPoints->drop_points = json_encode($request->drop_points);
            
            $dropPoints->last_drop = $request->drop_points[0]['time'];
            $dropPoints->save();
        }
        return response()->json(['flag'=>true,'message'=>'record updated','data'=>$dropPoints]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DropPoints  $dropPoints
     * @return \Illuminate\Http\Response
     */
    public function destroy(DropPoints $dropPoints)
    {
        //
    }
}
    