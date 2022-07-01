<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeatRequest;
use App\Http\Requests\UpdateSeatRequest;
use App\Models\Seat;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\WasSelected;
use App\Models\ConfirmedSeat;

class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->date && request()->bus_id) {
            # code...
            $seat_lower = DB::table('seats')->where('type','=','lower')->get();
            $seat_upper = DB::table('seats')->where('type','=','upper')->get();
            // $selected_seats = WasSelected::where('bus_id', request()->bus_id)->where('date',request()->date)->get();
            $confirmed_seats = ConfirmedSeat::where('bus_id', request()->bus_id)->where('date',request()->date)->where('status','1')->where('payment_status','1')->get();
            $array  = [];
            
            foreach ($confirmed_seats as $value) {
                foreach (json_decode($value->seatNo) as $seatNo) {
                    array_push($array,$seatNo);
                }
            }
            // foreach ($selected_seats as $value) {
            //     foreach ($value->selected_seats as $seatNo) {
            //         array_push($array,$seatNo);
            //     }
            // }
            $m = array_unique($array);
            foreach ($seat_lower as $key => $value) {
                if(in_array($value->seatNo,$m)){
                    $seat_lower[$key]->isSelected = 1;
                }
            }

            foreach ($seat_upper as $key => $value) {
                if(in_array($value->seatNo,$m)){
                    $seat_upper[$key]->isSelected = 1;
                }
            }
            // return $m;
            return response()->json(['flag'=>true, 'data'=>['lower'=>$seat_lower,'upper'=>$seat_upper]]);
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
     * @param  \App\Http\Requests\StoreSeatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'bus_id'=>'required',
            'selected_seats' => 'required',
            'total_amount' => 'required',
            'user_id' => 'required',
            'date'=>'required'
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
        $selected = WasSelected::where('bus_id',$request->bus_id)->where('user_id',$request->user_id)->first();
        if ($selected) {
            $selected->selected_seats = json_encode($request->selected_seats); 
            $selected->total_amount = $request->total_amount; 
            $selected->date = $request->date; 
            $selected->save();
        }else{
            $selected = new WasSelected();
            $selected->bus_id = $request->bus_id; 
            $selected->selected_seats = json_encode($request->selected_seats); 
            $selected->total_amount = $request->total_amount; 
            $selected->user_id = $request->user_id;
            $selected->date = $request->date; 
            $selected->save();
        }
        
        return response()->json(['flag'=>true,'message'=>'Record created successfully !', 'data'=>$selected]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seat  $seat
     * @return \Illuminate\Http\Response
     */
    public function show(Seat $seat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seat  $seat
     * @return \Illuminate\Http\Response
     */
    public function edit(Seat $seat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSeatRequest  $request
     * @param  \App\Models\Seat  $seat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSeatRequest $request, Seat $seat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seat  $seat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seat $seat)
    {
        //
    }
}
