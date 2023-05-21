<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreBusRequest;
use App\Http\Requests\UpdateBusRequest;
use App\Models\Bus;
use App\Models\Routes;
use App\Models\PickupPoints;
use App\Models\DropPoints;
use App\Models\DatePrice;
use App\Models\ConfirmedSeat;
use App\Models\Payment;
use App\Models\BusInactiveDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->agent_id) {
            $buses = Bus::where('agent_id',request()->agent_id)->get();
            return response()->json(['flag'=>true ,'data'=>$buses]);
        }   
        return response()->json(['flag'=>true ,'data'=>Bus::all()]);
    }

    public function filterbus()
    {
        if(request()->has('agent_id')){
            if (request()->from && request()->to) {
                $inactives = BusInactiveDate::where('date',request()->date)->pluck('bus_id')->toArray();
                $bus = DB::table('buses')
                    ->join('routes', 'buses.id', '=', 'routes.bus_id')
                        ->where('routes.from', 'like', '%'.request()->from.'%')
                        ->where('routes.to', 'like', '%'.request()->to.'%')
                    ->join('pickup_points', 'buses.id', '=', 'pickup_points.bus_id')
                        ->where('pickup_points.from', '=', request()->from)
                    ->join('drop_points', 'buses.id', '=', 'drop_points.bus_id')
                        ->where('drop_points.to', '=', request()->to)
                    ->join('date_prices', function ($join) {
                        $join->on('routes.id', '=', 'date_prices.route_id')
                             ->where('date', '=', request()->date);
                    })->where('buses.status','=','A')
                    ->where('buses.agent_id','=',request()->agent_id)
                    ->whereNotIn('buses.id',$inactives)
                    ->whereNotIn('buses.agent_id',DB::table('agents')->where('status','0')->pluck('id')->toArray())
                    ->select('buses.id', 'buses.travels_name','buses.image','date_prices.seats_avail','pickup_points.last_pick','drop_points.last_drop','buses.agent_id','date_prices.price', 'routes.from', 'routes.to')
                    ->distinct('buses.id')
                    ->get();
                $array = [];
                foreach ($bus as $value) {
                    $current_time = strtotime(Carbon::now());
                    $bus_time =strtotime(request()->date.' '.$value->last_pick);
                    if ($current_time<$bus_time) {
                        array_push($array,$value);
                    }
                } 
                return response()->json(['flag'=>true,'message'=>'success', 'data'=>$array]);
            }else{
                return response()->json(['flag'=>false, 'message'=>"please select city first"]);
            }
        }else{
            if (request()->from && request()->to) {
                $inactives = BusInactiveDate::where('date',request()->date)->pluck('bus_id')->toArray();
                $bus = DB::table('buses')
                    ->join('routes', 'buses.id', '=', 'routes.bus_id')
                         ->where('routes.from', 'like', '%'.request()->from.'%')
                        ->where('routes.to', 'like', '%'.request()->to.'%')
                    ->join('pickup_points', 'buses.id', '=', 'pickup_points.bus_id')
                        ->where('pickup_points.from', '=', request()->from)
                    ->join('drop_points', 'buses.id', '=', 'drop_points.bus_id')
                        ->where('drop_points.to', '=', request()->to)
                    ->join('date_prices', function ($join) {
                        $join->on('routes.id', '=', 'date_prices.route_id')
                             ->where('date_prices.date', '=', request()->date);
                    })->where('buses.status','=','A')
                    ->whereNotIn('buses.id',$inactives)
                    ->whereNotIn('buses.agent_id',DB::table('agents')->where('status','0')->pluck('id')->toArray())
                    ->select('buses.id', 'buses.travels_name','buses.image','date_prices.seats_avail','pickup_points.last_pick','drop_points.last_drop','buses.agent_id','date_prices.price', 'routes.from', 'routes.to')
                    ->distinct('buses.id')
                    ->get();
                    
                $array = [];
                foreach ($bus as $value) {
                    $current_time = strtotime(Carbon::now());
                    $bus_time =strtotime(request()->date.' '.$value->last_pick);
                    if ($current_time<$bus_time) {
                        array_push($array,$value);
                    }
                } 
                return response()->json(['flag'=>true,'message'=>'success', 'data'=>$array]);
            }else{
                return response()->json(['flag'=>false, 'message'=>"please select city first"]);
            }
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
     * @param  \App\Http\Requests\StoreBusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'plat_no' => 'unique:buses,plat_no',
            'plat_no' => 'unique:buses,plat_no',
            'from'=>'required',
            'to' => 'required',
            'price'=>'required',
            'default_price'=>'required',
            'agent_id'=>'required'
        ]);

        if ($validator->fails()) {
            $error = [];
            $error['flag']=false;
            $cnt = "message";
            foreach ($validator->errors()->toArray() as $key => $value) {
                $error[$cnt] = $value[0];
            }
            return response()->json($error);
        }
        #storing the bus
        $path = null;
        if ($request->hasFile('image')) {
            $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
            $ctime = date("Ymdhis");
            $file_name = $ctime.'.'.$extension;
            $path = $request->file('image')->move(public_path('/images'),$file_name);
            $reference = '/public/images/'.$file_name;
            $path = $reference;
        }
        $bus = new Bus();
        $bus->travels_name = $request->travels_name;
        $bus->image = $path;
        if($request->has('plat_no')) {
            $bus->plat_no = $request->plat_no;
        }
        $bus->agent_id = $request->agent_id;
        $bus->status = $request->status;
        $bus->save();

        #storing the routes
        $routes = new Routes();
        $routes->from = json_encode($request->from);
        $routes->to = json_encode($request->to);
        $routes->bus_id  = $bus->id;
        $routes->price = $request->price;
        $routes->save();

        #storing the defalt price with date
        if(!empty($request->default_price)){
            foreach ($request->default_price as $key => $value) {
                $dateprice = new DatePrice();
                $dateprice->date = $value['date'];
                $dateprice->price = $value['price'];
                $dateprice->route_id = $routes->id;
                $dateprice->save();
            }
        }   
        return response()->json(['flag'=>true,
            'message'=>'Record Successfully created!',
            'data'=>$bus],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function show($bus)
    {
        $bus = Bus::find($bus);
        if (!is_null($bus)) {
            return response()->json($bus);
        }else{
            return response()->json(['message'=>'bus not found']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function edit(Bus $bus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBusRequest  $request
     * @param  \App\Models\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bus)
    {
        // $validator= $request->validate([
        //     'bus_name'=>'required|unique:buses',
        //     'no_plate' => 'required',
        //     'agent_id' => 'required',
        //     'price' => 'required',
        //     'drop_point' => 'required',
        //     'pickup_point' => 'required',
        //     'pickup_time' => 'required',
        //     'drop_time' => 'required',
        //     'total_time' => 'required',
        //     'status' => 'required'
        // ]);
        try {
            $bus = Bus::find($bus);
                if (is_null($bus)) {
                    return response()->json(["error"=>"bus not found"]);
                }
                $bus->update($request->all());  
        } catch (\Throwable $th) {
            return response()->json(["error"=>$th]);
        }
        return response()->json([
            'message'=>'Record Successfully updated!',
            'data'=>$bus],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if (request()->bus_id) {
            $busid = request()->bus_id;
            $bus = Bus::find($busid);
            if (!is_null($bus)) {
                $seats = ConfirmedSeat::where('bus_id',$busid)
                    ->where('user_type','0')
                    ->whereRaw('CAST(CONCAT(STR_TO_DATE(confirmed_seats.date,"%d-%b-%Y")," ",confirmed_seats.pick_time) AS DATETIME) >= "'.now().'"')
                    ->get();

                if(count($seats)>0)
                {
                    return response()->json(['flag'=>false, 'message'=>'Deletion suspended, Bus contains advanced booking for upcoming date and time!']); 
                }
                // -------- getting routes for date price
                $routes = Routes::where('bus_id', $bus->id)->get();
                $m = $routes->pluck('id');
                $date_price = DatePrice::whereIn('route_id',$m)->delete();

                // -------- deleting routes -------------//
                $routes = Routes::where('bus_id', $bus->id)->delete();

                // ---------- deleting pickup points ------------//
                $pickup = PickupPoints::where('bus_id', $bus->id)->delete();
                
                // ---------- deletign drop points ------------//
                $drop = DropPoints::where('bus_id', $bus->id)->delete();
                
                //---------- deleting payments list ---------//
                $cs = ConfirmedSeat::where('bus_id', $bus->id)->delete();
                
                // deleting bus too
                $bus->delete();
                return response()->json(['flag'=>true,'message'=>'Record successfully deleted']);
            }else{
                return response()->json(['flag'=>false, 'message'=>'Record not founds']);
            }
        }
    }

    public function showHideBus(Request $request)
    {
        if ($request->bus_id && $request->status) {
            // if ($request->status != 'A' || $request->status != 'D' ) {
            //     return response()->json(['flag'=>false, 'message'=>'status have only 2 values either A or D']); 
            // }
            $bus = Bus::find($request->bus_id);
            if (!is_null($bus)) { 
                if($request->status== 'D')
                {
                    $seats = ConfirmedSeat::where('bus_id',$request->bus_id)
                        ->where('user_type','0')
                        ->whereRaw('CAST(CONCAT(STR_TO_DATE(confirmed_seats.date,"%d-%b-%Y")," ",confirmed_seats.pick_time) AS DATETIME) >= "'.now().'"')
                        ->get();

                    if(count($seats)>0)
                    {
                        return response()->json(['flag'=>false, 'message'=>'De-activation suspended, Bus contains advanced booking for upcoming date and time!']); 
                    }
                }  
                $bus->status = $request->status;
                $bus->save();
                return response()->json(['flag'=>true, 'message'=>'status changes successfully','data'=>$bus]); 
            }else{
                return response()->json(['flag'=>false, 'message'=>'bus not found']); 
            }
        }else{
            return response()->json(['flag'=>false, 'message'=>'buse_id and status are needed']); 
        }
    }

    public function deactivateByDate(Request $request)
    {
        if ($request->bus_id && $request->date && $request->status) {
            // if ($request->status != 'A' || $request->status != 'D' ) {
            //     return response()->json(['flag'=>false, 'message'=>'status have only 2 values either A or D']); 
            // }
            $bus = Bus::find($request->bus_id);
            if (!is_null($bus)) { 
                if($request->status=='D')
                {
                    $seats = ConfirmedSeat::where('bus_id',$request->bus_id)
                        ->where('user_type','0')
                        ->where('confirmed_seats.date',$request->date)
                        ->get();

                    if(count($seats)>0)
                    {
                        return response()->json(['flag'=>false, 'message'=>'De-activation suspended, Bus contains advanced booking for given date!']); 
                    }

                    $obj = BusInactiveDate::firstOrCreate([
                        'bus_id'=>$request->bus_id,
                        'date'=>$request->date]);

                    if ($obj->wasRecentlyCreated)
                        return response()->json(['flag'=>true, 'message'=>'Successfully deactivated for date: '.$request->date,'data'=>$bus]); 
                    else
                        return response()->json(['flag'=>true, 'message'=>'Already deactivated for date: '.$request->date,'data'=>$bus]); 
                }
                $obj = BusInactiveDate::where('date',$request->date)->where('bus_id',$request->bus_id)->first();
                if(!empty($obj))
                {
                    BusInactiveDate::where('date',$request->date)->where('bus_id',$request->bus_id)->delete();
                    return response()->json(['flag'=>true, 'message'=>'Successfully activated for date: '.$request->date,'data'=>$bus]); 
                }
                return response()->json(['flag'=>true, 'message'=>'Already active for date: '.$request->date,'data'=>$bus]); 
            }else{
                return response()->json(['flag'=>false, 'message'=>'bus not found']); 
            }
        }else{
            return response()->json(['flag'=>false, 'message'=>'buse_id, date and status are needed']); 
        }
    }

    public function getBuses()
    {
        if (request()->agent_id) {
            return response()->json(['flag'=>true ,'data'=>Bus::where('agent_id',request()->agent_id)->with('routes')->get()]);
        }else{
            return response()->json(['flag'=>true,'message'=>'agent_id not passed']);
        }
    }
}
