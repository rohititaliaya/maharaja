<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoutesRequest;
use App\Http\Requests\UpdateRoutesRequest;
use App\Models\Routes;
use App\Models\Bus;
use App\Models\DatePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->bus_id) {
            $routes = Routes::where('bus_id', request()->bus_id)->select('id','from','to')->get();
            return response()->json(['flag'=>true, 'data'=>$routes]);
        }else{
            return response()->json(['flag'=>false, 'message'=>'bus id missmatch in url you pass']);
        }
    }

    public function index2()
    {
        if (request()->bus_id) {
            $routes = Routes::where('bus_id', request()->bus_id)->first();
            $dateprice = DatePrice::where('route_id', $routes->id)->get();
            $routes['date_prices'] = $dateprice; 
            return response()->json(['flag'=>true,'message'=> 'success','data'=>$routes]);
        }else{
            return response()->json(['flag'=>false, 'message'=>'bus id missmatch in url you pass']);
        }
    }

    public function updateBusAndRoutes(Request $request)
    {
        if (request()->bus_id) {
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
            $bus = Bus::find(request()->bus_id);
            $bus->travels_name = $request->travels_name;
            $bus->image = $path;
            if($request->has('plat_no')) {
                $bus->plat_no = $request->plat_no;
            }
            $bus->agent_id = $request->agent_id;
            $bus->status = $request->status;
            $bus->save();
    
            #storing the routes
            $routes = Routes::where('bus_id', request()->bus_id)->first();
            $routes->from = json_encode($request->from);
            $routes->to = json_encode($request->to);
            $routes->bus_id  = $bus->id;
            $routes->price = $request->price;
            $routes->save();
            return response()->json(['flag'=>true,'message'=> 'success','data'=>$routes]);
        }else{
            return response()->json(['flag'=>false, 'message'=>'Record not found !']);
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
     * @param  \App\Http\Requests\StoreRoutesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'from'=>'required',
            'to' => 'required',
            'price'=>'required',
            'default_price'=>'required',
            'bus_id' =>'required'
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
            $bus = Bus::find($request->bus_id);
            if (!is_null($bus)) {
                $check = Routes::where('bus_id', $request->bus_id)->where('from', $request->from)->where('to',$request->to)->first();
                if($check){
                    return response()->json(['flag'=>false,'message'=>'Route already available']);
                }
                $routes = new Routes();
                $routes->from = $request->from;
                $routes->to = $request->to;
                $routes->bus_id  = $request->bus_id;
                $routes->price = $request->price;
                $routes->save();
                if(!empty($request->default_price)){
                    foreach ($request->default_price as $key => $value) {
                        $dateprice = new DatePrice();
                        $dateprice->date = $value['date'];
                        $dateprice->price = $value['price'];
                        $dateprice->route_id = $routes->id;
                        $dateprice->save();
                    }
                }
            }else{
                return response()->json(['flag'=>false,'message'=>'bus not found']);
            }
        } catch (\Throwable $th) {
            return response()->json(["error"=>$th]);
        }
        return response()->json([
                'flag'=>true,
                'message'=>'Record Successfully created!',
                'data'=>['route'=>$routes]
            ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Routes  $routes
     * @return \Illuminate\Http\Response
     */
    public function show(Routes $routes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Routes  $routes
     * @return \Illuminate\Http\Response
     */
    public function edit(Routes $routes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoutesRequest  $request
     * @param  \App\Models\Routes  $routes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'plat_no' => 'unique:buses,plat_no,'.$request->bus_id,
        ]);

        if ($validator->fails()) {
            $error = [];
            $error['flag']=false;
            foreach ($validator->errors()->toArray() as $key => $value) {
                $error['message'] = $value[0];
            }
            return response()->json($error);
        }
        #updating the bus
        $reference = null;
        if ($request->hasFile('image')) {
            $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
            $ctime = date("Ymdhis");
            $file_name = $ctime.'.'.$extension;
            $path = $request->file('image')->move(public_path('/images'),$file_name);
            $reference = '/public/images/'.$file_name;
            // $request['image'] = $reference;
        }
        $bus = Bus::find($request->bus_id);
        $bus->travels_name = $request->travels_name;
        $bus->image = $reference;
        $bus->plat_no = $request->plat_no;
        $bus->save();
        // finding the route
        $routes = Routes::where('bus_id', $request->bus_id)->first();
        if($routes){
            if ($request->price) {
                $routes->price = $request->price; 
            }
            if ($request->from) {
                $routes->from = json_encode($request->from); 
            }
            if ($request->to) {
                $routes->to = json_encode($request->to); 
            }
            $routes->save();
            // updateing the default date price
            if(!empty($request->default_price)){
                foreach ($request->default_price as $key => $value) {
                    $dateprice = DatePrice::where('route_id',$routes->id)->where('date',$value['date'])->first();
                    $dateprice->date = $value['date'];
                    $dateprice->price = $value['price'];
                    $dateprice->save();
                }
            }
        }
        return response()->json(['flag'=>true,'message'=>'record updated successfully !']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Routes  $routes
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if(request()->route_id){
            $route = Routes::find(request()->route_id);
            if (!is_null($route)) {
                $route->delete();
                return response()->json(['flag'=>true, 'message'=>'successfully deleted']);
            }else{
                return response()->json(['flag'=>false, 'message'=>'record not found']);
            }  
        }else{
            return response()->json(['flag'=>false, 'message'=>'route_id is null']);
        }
    }
}
