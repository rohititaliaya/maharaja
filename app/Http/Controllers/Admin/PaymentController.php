<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\ConfirmedSeat;
use App\Models\Setting;
use Razorpay\Api\Api as RazorpayApi;
use DataTables;
use Session;
use Carbon\Carbon;
use Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        if(Session::get("is_loggedin") == false && empty(Session::get('is_loggedin'))) {
            return redirect()->to('/login')->send();
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Payment::select('*')->with(['book','agent']);
            $commission_rate = json_decode(Setting::find(1)->values)->commission_rate;
            $tax_rate = json_decode(Setting::find(1)->values)->tax_rate;
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('payment_status',function($data){
                if($data->payment_status==0)
                    return '<span class="badge bg-danger">Not Paid</span>';
                else if($data->payment_status==1)
                    return '<span class="badge bg-info">Captured</span>';
                else if($data->payment_status==2)
                    return '<span class="badge bg-success">Transfered</span>';
                else if($data->payment_status==3)
                    return '<span class="badge bg-warning">Refunded</span>';
                else
                    return '<span class="badge bg-secondary">Unknow Status</span>';
            })
            ->addColumn('on_hold',function($data){
                if($data->transfer_on_hold==1)
                    return '<span class="text-success">Yes</span>';
                else
                    return '<span class="text-danger">No</span>';
            })
            ->addColumn('hold_till',function($data){
                if(empty($data->transfer_hold_till))
                    return '-';
                else
                    return $data->transfer_hold_till;
            })
            ->addColumn('name',function($data){
                if(!empty($data->agent_id))
                    return $data->agent->name;
                else
                    return '-';
            })
            ->addColumn('action',function($data){
                if(empty($data->transfer_id) && $data->payment_status<2)
                    return '<form method="post" action="'.route('payment.transfer',$data->id).'"><input type="hidden" name="_token" value="'.csrf_token().'"><button type="submit" class="btn btn-success btn-sm">Retry Transfer</button></form>';
                else if(empty($data->transfer_id) && $data->payment_status==3)
                    return '<span class="text-success">Refunded</span>';
                else
                    return '<span class="text-success">Already Transfered</span>';
            })
            ->rawColumns(['payment_status','on_hold','action'])
            ->make(true);
        }
        return view('payment.index');
    }

    public function paymentTransfer(Payment $payment)
    {
        $api = new RazorpayApi(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

        try
        {
            $paymentDtl = $api->payment->fetch($payment->transaction_id);
        }
        catch(\Exception $e)
        {
            Log::error("Razorpay: ".$e->getMessage());
            return redirect()->back()->with("error",'Error while creating Razorpay transfer! ');
        }

        if($paymentDtl->status=='captured')
        {
            if(count($transfers = $paymentDtl->transfers())>0)
            {
                $payment->agent_id = $payment->book->bus->agent_id;
                $payment->transfer_id = $transfers->items[0]->id;
                $payment->transfer_on_hold = $transfers->items[0]->on_hold;
                $payment->transfer_hold_till = $transfers->items[0]->on_hold_until;
                $payment->save();
                return redirect()->back()->with('error','Transfer alreay exist for given payment Id!');
            }
                // dd($transfers->items[0]->id);   

            $cs = ConfirmedSeat::find($payment->book_id);
            $bus = [];
            $agent = [];
            if(empty($bus = $cs->bus))
            {
                return redirect()->back()->with('error','Bus not found related to booking id!');  
            }

            if(empty($agent = $cs->bus->agent))
            {
                return redirect()->back()->with('error', 'Agent not found related to booking id!');  
            }
            $amount = $cs->total_amount;
            $commission_rate = json_decode(Setting::find(1)->values)->commission_rate;

            $tax_rate = json_decode(Setting::find(1)->values)->tax_rate;

            $amount_without_tax = round($amount*100/(100+$tax_rate),2);

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
                $transfer = $api->payment->fetch($payment->transaction_id)->transfer($array);
            }
            catch(\Exception $e)
            {
                return redirect()->back()->with('error',$e->getMessage());
            }
            $payment->payment_status=2;
            $payment->total_amount=$cs->total_amount;
            $payment->amount_without_tax=$amount_without_tax;
            $payment->transfered_amount=$payable;
            $payment->agent_id = $agent->id;
            $payment->transfer_id = $transfer->items[0]->id;
            $payment->transfer_on_hold = $onHold;
            $payment->transfer_hold_till = $date;
            $payment->save();

             return redirect()->back()->with('success','Transfer created successfully');

        }
        return redirect()->back()->with('error','Payment status is not Captured, Cannot transfer payment!');

    }

    public function getCustomFilterData(Request $request)
    {

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
