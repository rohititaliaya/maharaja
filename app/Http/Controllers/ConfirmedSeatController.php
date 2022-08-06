<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Requests\StoreConfirmedSeatRequest;
use App\Http\Requests\UpdateConfirmedSeatRequest;
use App\Models\ConfirmedSeat;
use App\Models\DropPoints;
use App\Models\PickupPoints;
use App\Models\WasSelected;
use App\Models\Bus;
use App\Models\Payment;
use App\Models\Agent;
use App\Models\User;
use App\Models\DatePrice;
use App\Models\Routes;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use DB;
use App\Services\FCMService;
use Razorpay\Api\Api as RazorpayApi;
use Illuminate\Support\Facades\Log;


class ConfirmedSeatController extends Controller
{
    /**
     * Get pickup points and drop points.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->bus_id && request()->from && request()->to) {
            $pick = PickupPoints::where('from', request()->from)->where('bus_id', request()->bus_id)->select('pickup_points')->first();
            $drop = DropPoints::where('to', request()->to)->where('bus_id', request()->bus_id)->select('drop_points')->first();
            if (!$drop) {
                return response()->json(['flag'=>false, 'message'=>'drop point not found !']);
            }
            if(!$pick){
                return response()->json(['flag'=>false, 'message'=>'pickup points not found !']);
            }
            return response()->json(['flag'=>true,'pickup_points'=>$pick->pickup_points,'drop_points'=>$drop->drop_points]);
            
        }else{
            return response()->json(['flag'=>false, 'message'=> 'missing parameter from bus_id, from or to']);
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
     * @param  \App\Http\Requests\StoreConfirmedSeatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'bus_id'=>'required',
            'mobile' => 'required',
            'passenger_name' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'pickup_point' => 'required',
            'drop_point' => 'required',
            'pick_time' => 'required',
            'drop_time' => 'required',
            'user_id' => 'required',
            'selected_seats'=>'required',
            'total_amount'=>'required',
            'date' => 'required'
        ]);

        if ($validator->fails()) {
            $error = [];
            $error['flag']=false;
            
            $error['message'] = $validator->errors()->first();
            return response()->json($error);
        }
        $mConfirmed = ConfirmedSeat::where('bus_id',$request->bus_id)->where('date',$request->date)->where('status','1')->where('payment_status','1')->pluck('seatNo')->toArray();

        $array = [];
        foreach ($mConfirmed as $key => $value) {
            $m = json_decode($value);
            if (empty($array)) {
                $array = $m;
            }else{
               $array = array_merge($m,$array);
            }
        }
        $array= array_unique($array);
        $repq = [];
        foreach ($request->selected_seats as $key => $value) {
            if (in_array($value, $array)) {
                array_push($repq, $value);
            }
        }
        if (!empty($repq)) {
            return response()->json(['flag'=>false,'message'=>''.implode(' & ',$repq).' seats are already booked. Please select another seats.']);    
        }
        
        $mprocess = ConfirmedSeat::where('bus_id',$request->bus_id)->where('date',$request->date)->where('status','0')->where('payment_status','0')->pluck('seatNo')->toArray();

        $array1 = [];
        foreach ($mprocess as $key => $value) {
            $m = json_decode($value);
            if (empty($array1)) {
                $array1 = $m;
            }else{
               $array1 = array_merge($m,$array1);
            }
        }
        $array1= array_unique($array1);
        $repq1 = [];
        foreach ($request->selected_seats as $key => $value) {
            if (in_array($value, $array1)) {
                array_push($repq1, $value);
            }
        }
        if (!empty($repq1)) {
            return response()->json(['flag'=>false,'message'=>'someone processing for seats '.implode(' & ',$repq1).'  wait...']);    
        }

        /****Razorpay create order****/
        $rapi = new RazorpayApi(env('RAZORPAY_KEY_ID'),env('RAZORPAY_KEY_SECRET'));

        $razorpayOrderData = [
            'receipt'         => $request->user_id.'_'.time(),
            'amount'          => $request->total_amount*100,
            'currency'        => 'INR'
        ];

        $razorpayOrder = $rapi->order->create($razorpayOrderData);
        /****Razorpay create order****/

        $cbookbus = new ConfirmedSeat();
        $cbookbus->bus_id = $request->bus_id;
        $cbookbus->passenger_name = $request->passenger_name;
        if ($request->user_type == "1") {
            $bus = Bus::find($request->bus_id);
            $cbookbus->passenger_name = $bus->travels_name;
        }    
        $cbookbus->mobile = $request->mobile;
        $cbookbus->age = $request->age;
        $cbookbus->gender = $request->gender;
        $cbookbus->pickup_point = $request->pickup_point;
        $cbookbus->drop_point = $request->drop_point;
        $cbookbus->pick_time = $request->pick_time;
        $cbookbus->drop_time = $request->drop_time;
        $cbookbus->user_id = $request->user_id;
        $cbookbus->from = $request->from;
        $cbookbus->to = $request->to;
        $cbookbus->date = $request->date;
        $cbookbus->seatNo = json_encode($request->selected_seats);
        $cbookbus->total_amount = $request->total_amount;
        $cbookbus->razorpay_order_id = $razorpayOrder['id'];
        $cbookbus->status = '0';
        $cbookbus->user_type = $request->user_type;
        $cbookbus->payment_status = "0";
        if ($request->user_type == "1") {
            $cbookbus->status = '1';
            $cbookbus->payment_status = "1";
        }
        $cbookbus->save();  
        $bus_agent = Bus::find($cbookbus->bus_id);
        
        if ($request->user_type == "1") {
            $agent = Agent::find($request->user_id);
                    
                // counting seats array
                $ccseat = DB::table('confirmed_seats')->where('id', '=', $cbookbus->id)->first();
                $bus_id = $ccseat->bus_id;
                $from = $ccseat->from;
                $to = $ccseat->to;
                $date = $ccseat->date;

                $route = Routes::where('bus_id',$bus_id)->first();
                
                $date_price_seats = DatePrice::where('route_id', $route->id)->where('date', $date)->first();
                $seats = json_decode($ccseat->seatNo);
                $total_count = 0;
                foreach ($seats as $value) {
                    $m = explode(',',$value);
                    $c = count($m);
                    $total_count = $total_count + $c;
                }
                $date_price_seats->seats_avail = $date_price_seats->seats_avail - $total_count;
                $date_price_seats->save(); 
            
            FCMService::send(
                $agent->fcmid,
                [ 
                    'title' => "Bus Booking",
                    'body' => ''.implode(' , ', $seats).' seat book successfully in '.$bus_agent->travels_name.''  
                ]
            );
            $cbookbus->travels_name = $bus_agent->travels_name;
            return response()->json(['flag'=>true,'message'=>'seat booked successfully !','data'=>$cbookbus]);
        }
        $cbookbus->travels_name = $bus_agent->travels_name;
        return response()->json(['flag'=>true,'message'=>'seat booked successfully !','data'=>$cbookbus]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConfirmedSeat  $confirmedSeat
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // $ccseat = Bus::with('cseat')->where('agent_id', request()->agent_id)->select()->get();
        // return $ccseat;
        if (request()->agent_id) {
            $a = request()->agent_id;
            $buses = Bus::where('agent_id',$a)->pluck('id')->toArray();
            $ccseat = DB::table('confirmed_seats')
            ->join('buses', 'confirmed_seats.bus_id', '=', 'buses.id')
            ->join('agents', 'buses.agent_id', '=', 'agents.id')
            ->join('cities as fromx', 'confirmed_seats.from', '=', 'fromx.id')
            ->join('cities as tox', 'confirmed_seats.to', '=', 'tox.id')
            ->whereIn('buses.id', $buses)
            ->where('confirmed_seats.status', '=', '1')
            ->where('confirmed_seats.payment_status','=','1')
            ->select('confirmed_seats.*', 'buses.travels_name','fromx.name as from','tox.name as to','agents.mobile as agent_no')
            ->get();
            return response()->json(['flag'=>true, 'data'=>$ccseat]); 
        }else{
            return response()->json(['flag'=>true, 'message'=>'agent_id is missing !']); 
        }
    }

    public function showCansal()
    {
        if (request()->agent_id) {
            $a = request()->agent_id;
            $buses = Bus::where('agent_id',$a)->pluck('id')->toArray();
            $ccseat = DB::table('confirmed_seats')
            ->join('buses', 'confirmed_seats.bus_id', '=', 'buses.id')
            ->join('agents', 'buses.agent_id', '=', 'agents.id')
            ->join('cities as fromx', 'confirmed_seats.from', '=', 'fromx.id')
            ->join('cities as tox', 'confirmed_seats.to', '=', 'tox.id')
            ->whereIn('buses.id', $buses)
            ->where('confirmed_seats.status', '=', '0')
            ->select('confirmed_seats.*', 'buses.travels_name','fromx.name as from','tox.name as to','agents.mobile as agent_no')
            ->get();
            return response()->json(['flag'=>true, 'data'=>$ccseat]); 
        }else{
            return response()->json(['flag'=>true, 'message'=>'agent_id is missing !']); 
        }
    }
    
    public function usershow()
    {
        if (request()->user_id) {
            $a = request()->user_id;
            $ccseat = DB::table('confirmed_seats')
            ->join('buses', 'confirmed_seats.bus_id', '=', 'buses.id')
            ->join('agents', 'buses.agent_id', '=', 'agents.id')
            ->join('cities as fromx', 'confirmed_seats.from', '=', 'fromx.id')
            ->join('cities as tox', 'confirmed_seats.to', '=', 'tox.id')
            ->where('confirmed_seats.user_id', '=', $a)
            ->where('confirmed_seats.status', '=', '1')
            ->where('confirmed_seats.payment_status','=','1')
            ->where('confirmed_seats.user_type', '=', '0')
            ->select('confirmed_seats.*', 'buses.travels_name','fromx.name as from','tox.name as to','agents.mobile as agent_no')
            ->get();
            return response()->json(['flag'=>true, 'data'=>$ccseat]); 
        }else{
            return response()->json(['flag'=>true, 'message'=>'user_id is missing !']); 
        }
    }

    public function usershowCansal()
    {
        if (request()->user_id) {
            $a = request()->user_id;
            $ccseat = DB::table('confirmed_seats')
            ->join('buses', 'confirmed_seats.bus_id', '=', 'buses.id')
            ->join('agents', 'buses.agent_id', '=', 'agents.id')
            ->join('cities as fromx', 'confirmed_seats.from', '=', 'fromx.id')
            ->join('cities as tox', 'confirmed_seats.to', '=', 'tox.id')
            ->where('confirmed_seats.user_id', '=', $a)
            ->where('confirmed_seats.status', '=', '0')
            ->select('confirmed_seats.*', 'buses.travels_name','fromx.name as from','tox.name as to','agents.mobile as agent_no')
            ->get();
            return response()->json(['flag'=>true, 'data'=>$ccseat]); 
        }else{
            return response()->json(['flag'=>true, 'message'=>'user_id is missing !']); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConfirmedSeat  $confirmedSeat
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfirmedSeat $confirmedSeat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateConfirmedSeatRequest  $request
     * @param  \App\Models\ConfirmedSeat  $confirmedSeat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConfirmedSeatRequest $request, ConfirmedSeat $confirmedSeat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConfirmedSeat  $confirmedSeat
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfirmedSeat $confirmedSeat)
    {
        //
    }
    
    public function cansal()
    {
        if (request()->user_id && request()->book_id) {
            $confirm_seat = ConfirmedSeat::find(request()->book_id);
            $bdate = $confirm_seat->date;
            $bptime = $confirm_seat->pick_time;
            $date = $bdate.' '.$bptime;
            $newDate = date('Y-m-d H:i:s', strtotime($date. ' -3 hours'));
            $d1 = strtotime(Carbon::now()->format('d-M-Y H:m'));
            $d2 =strtotime($newDate);
            if ($d2<$d1) {
                return response()->json(['flag'=>false,'message'=>'you can not cansal seat now !']);
            }
            if($confirm_seat){
                $confirm_seat->status = '0';
                $confirm_seat->save();

                /*****Processing Refunds*****/
                if(!empty($confirm_seat->payment))
                {
                    $api = new RazorpayApi(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

                    $cancelation_charge = json_decode(Setting::find(1)->values)->cancelation_charge;
                    $tax_rate = json_decode(Setting::find(1)->values)->tax_rate;
                    $amount = $confirm_seat->total_amount;

                    $amount_without_tax = round($amount*100/(100+$tax_rate),2);

                    $refundable = round($amount_without_tax-($amount_without_tax*$cancelation_charge/100),2);

                    $razorRefund = [];
                    try
                    {
                        $razorRefund = $api->payment->fetch($confirm_seat->payment->transaction_id)->refund(array('amount'=> $refundable*100,'reverse_all'=>'1'));
                    }
                    catch(\Exception $e)
                    {
                        Log::error("Razorpay: ".$e->getMessage());
                        return response()->json(["flag"=>false,"message"=>'Error while creating Razorpay Refund! ']);
                    }
                    $confirm_seat->payment->update([
                        'payment_status'=>3,
                        'refunded_amount'=> $refundable,
                        'refund_obj'=>json_encode($razorRefund->toArray())]);
                }
                
                /*****Processing Refunds*****/           
                
                // counting seats array
                $ccseat = DB::table('confirmed_seats')->where('id', '=', $confirm_seat->id)->first();
                $bus_id = $ccseat->bus_id;
                $from = $ccseat->from;
                $to = $ccseat->to;
                $date = $ccseat->date;

                $route = Routes::where('bus_id',$bus_id)->first();
                
                $date_price_seats = DatePrice::where('route_id', $route->id)->where('date', $date)->first();
                $seats = json_decode($ccseat->seatNo);
                $total_count = 0;
                foreach ($seats as $value) {
                    $m = explode(',',$value);
                    $c = count($m);
                    $total_count = $total_count + $c;
                }
                $date_price_seats->seats_avail = $date_price_seats->seats_avail + $total_count;
                $date_price_seats->save(); 

                $bus_agent = Bus::find($ccseat->bus_id);
                if ($ccseat->user_type == '1') {
                    $agents = Agent::find($bus_agent->agent_id);
                    FCMService::send(
                        $agents->fcmid,
                        [
                            'title' => "Bus Booking System",
                            'body' => ''.implode(' , ',$seats).' seat cancelled successfully in '.$bus_agent->travels_name.''  
                        ]
                    );
                }
                
                if ($ccseat->user_type == '0') {
                    $user = User::find($ccseat->user_id);
                    FCMService::send(
                    $user->fcmid,
                        [ 
                            'title' => "Bus Booking System",
                            'body' => ''.implode(' , ', $seats).' seat cancelled successfully in '.$bus_agent->travels_name.''
                        ]
                    );
                    $agents = Agent::find($bus_agent->agent_id);
                    FCMService::send(
                        $agents->fcmid,
                        [
                            'title' => "Bus Booking System",
                            'body' => ''.implode(' , ', $seats).' seat has been cancelled in '.$bus_agent->travels_name.''  
                        ]
                    );
                }  

                return response()->json(['flag'=>true,'message'=>'seat cansalled']);
            }else{
                return response()->json(['flag'=>false,'message'=>'seat not found in booking']);
            }

        }
    }

    public function payment_status(Request $request)
    {
        if($request->status  == '0'){
            $cs = ConfirmedSeat::find($request->book_id);
            $cs->delete();
            return response()->json(['flag'=>true, 'message'=>'Payment Failed !']);
        }else{
            // $p = Payment::where('transaction_id');
            // if(!empty($p))
            //     return response()->json(['flag'=>false,'message'=>'Transaction id already in use!']);
            $p = new Payment();
            $p->book_id = $request->book_id;
            $p->user_id = $request->user_id;
            $p->status = $request->status; 
            if ($request->has('transaction_id')) {
                $p->transaction_id = $request->transaction_id; 
            }
            $p->save();
    
            $cs = ConfirmedSeat::find($request->book_id);
            if ($cs) {
                $cs->status = $request->status;
                $cs->payment_status = $request->status;
                $cs->save();

                // counting seats array
                $ccseat = DB::table('confirmed_seats')->where('id', '=', $cs->id)->first();
                $bus_id = $ccseat->bus_id;
                $from = $ccseat->from;
                $to = $ccseat->to;
                $date = $ccseat->date;

                $route = Routes::where('bus_id',$bus_id)->first();
                
                $date_price_seats = DatePrice::where('route_id', $route->id)->where('date', $date)->first();
                $seats = json_decode($ccseat->seatNo);
                $total_count = 0;
                foreach ($seats as $value) {
                    $m = explode(',',$value);
                    $c = count($m);
                    $total_count = $total_count + $c;
                }
                $date_price_seats->seats_avail = $date_price_seats->seats_avail - $total_count;
                $date_price_seats->save(); 
            
                $bus_agent = Bus::find($cs->bus_id);
                if ($cs->user_type == '1') {
                    $agents = Agent::find($bus_agent->agent_id);
                    FCMService::send(
                        $agents->fcmid,
                        [
                            'title' => "Bus Booking System",
                            'body' => ''.implode(' , ',$seats).' seat is booked in '.$bus_agent->travels_name.''  
                        ]
                    );
                }
                
                if ($cs->user_type == '0') {
                    $user = User::find($request->user_id);
                    FCMService::send(
                    $user->fcmid,
                        [ 
                            'title' => "Bus Booking System",
                            'body' => ''.implode(' , ', $seats).' seat book successfully in '.$bus_agent->travels_name.''
                        ]
                    );
                    $agents = Agent::find($bus_agent->agent_id);
                    FCMService::send(
                        $agents->fcmid,
                        [
                            'title' => "Bus Booking System",
                            'body' => ''.implode(' , ', $seats).' seat is booked in '.$bus_agent->travels_name.''  
                        ]
                    );
                }   

                /*****Create Transfer from razorpay*****/
                $api = new RazorpayApi(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

                $paymentDtl = $api->payment->fetch($request->transaction_id);

                if($paymentDtl->status=='captured')
                {
                    $p->update(['payment_status' => 1]);

                    if(count($transfers = $paymentDtl->transfers())>0)
                        return response()->json(['flag'=>true,'message'=>'Transfer alreay exist for given payment Id!','data'=>$transfers->items[0]->toArray()]);
                        // dd($transfers->items[0]->id);   

                    $cs = ConfirmedSeat::find($request->book_id);
                    $bus = [];
                    $agent = [];
                    if(empty($bus = $cs->bus))
                    {
                        return response()->json(['flag'=>false, 'message'=>'Bus not found related to booking id!']);  
                    }

                    if(empty($agent = $cs->bus->agent))
                    {
                        return response()->json(['flag'=>false, 'message'=>'Agent not found related to booking id!']);  
                    }
                    $amount = $cs->total_amount;
                    $commission_rate = json_decode(Setting::find(1)->values)->commission_rate;
                    $tax_rate = json_decode(Setting::find(1)->values)->tax_rate;

                    $amount_without_tax = round($amount*100/(100+$tax_rate),2);

                    $p->total_amount = $cs->total_amount;
                    $p->amount_without_tax = $amount_without_tax;
                    $p->save();

                    $payable = round($amount_without_tax-($amount_without_tax*$commission_rate/100),2);
                    $date = Carbon::create($cs->date.' '.$cs->pick_time);
                    $onHold = 1;
                    $timestamp = $date->timestamp;
                    if($date->lt(Carbon::now()))
                    {
                        $onHold = 0;
                        $timestamp = null;
                    }
                    $array = [
                        'transfers' => [
                            [
                                'account'=> $agent->razorpay_acc_id, 
                                'amount'=> $payable*100, 
                                'currency'=>'INR', 
                                'notes'=> [
                                    'name'=>$agent->name, 
                                    'contact'=>$agent->mobile
                                ], 
                            // 'linked_account_notes'=>array('branch'), 
                                'on_hold'=>$onHold, 
                                'on_hold_until'=>$timestamp
                            ],
                        ]
                    ];

                    try
                    {
                        $transfer = $api->payment->fetch($request->transaction_id)->transfer($array);
                    }
                    catch(\Exception $e)
                    {
                        Log::error("Razorpay: ".$e->getMessage());
                        return response()->json(["flag"=>false,"message"=>'Error while creating Razorpay transfer! ']);
                    }
                    $p->payment_status = 2;
                    $p->agent_id = $agent->id;
                    $p->transfer_id = $transfer->items[0]->id;
                    $p->transfer_on_hold = $onHold;
                    $p->transfer_hold_till = $date;
                    $p->transfered_amount = $payable;
                    $p->save();

                }
                
                return response()->json(['flag'=>true, 'message'=>'stored successfully!']);    
            }else{
                
                return response()->json(['flag'=>false, 'message'=>'seat not found in confirmed table']);
            }
        }
    }
}
