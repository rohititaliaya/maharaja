<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\ConfirmedSeat;
use App\Models\BankDetail;
use App\Models\Bus;
use App\Models\DropPoints;
use App\Models\PickupPoints;
use App\Models\Routes;
use App\Models\DatePrice;
use DataTables;
use App\Services\FCMService;
use Session;
use Validator;
use DB;

class AgentController extends Controller
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
            $data = Agent::select('*');
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $btn = '';
                    if ($row->status == "0") {
                        $btn = '<a href="/agent/agent-approve/'.$row->id.'" class="edit btn btn-info btn-sm mx-2"> Approve</a>';
                        $btn = $btn.'<a href class="btn btn-sm btn-danger deleteModal" data-toggle="modal" data-target="#deleteAlert" data-id="'.$row->id.'">Delete</button></a>';
                    }else{
                        $btn = '<a href="/agent/agent-dis-approve/'.$row->id.'" class="edit btn btn-danger btn-sm mx-2">Dis-Approve</a>';
                    }
                    return $btn;
                })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('agents.index');
    }

   public function approve(Request $request)
    {
        $agent = Agent::find($request->id);
        $agent->status = "1";   
        $agent->save();
        FCMService::send(
            $agent->fcmid,
            [
                'title' => 'Bus Booking',
                'body' => 'Your account is approved !',
            ]
        );
        return redirect()->back()->with('success', 'request approved successfully');
    }

    public function DisApprove(Request $request)
    {
        $agent = Agent::find($request->id);

        if(count($agent->buses)>0)
        {
            $buses = $agent->buses->pluck('id')->toArray();
            $seats = ConfirmedSeat::whereIn('bus_id',$buses)
                ->where('user_type','0')
                ->whereRaw('CAST(CONCAT(STR_TO_DATE(confirmed_seats.date,"%d-%b-%Y")," ",confirmed_seats.pick_time) AS DATETIME) >= "'.now().'"')
                ->get();
            if(count($seats)>0)
            {
                return redirect()->back()->with('error','Dis-approval suspended, Agent\'s Bus(es) has confirmed tickets for upcoming Date and time');
            }
        }

        $agent->status = "0";
        $agent->save();
        FCMService::send(
            $agent->fcmid,
            [
                'title' => 'Bus Booking',
                'body' => 'Your account is dis-approved !',
            ]
        );
        return redirect()->back()->with('success', 'request approved successfully');
    }

    public function razorpayIdUpdate(Request $request)
    {
        if(empty($request->razorpay_acc_id))
        {
            return redirect()->back()->with('error','Razorpay Acc Id Required!');
        }
        $agent = Agent::findOrFail($request->id);

        $agent->update($request->only('razorpay_acc_id'));
        return redirect()->back()->with('success','Razorpay Acc Id updated successfully');
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
    public function destroy(Agent $agent)
    {
        $buses = [];
        if(count($agent->buses)>0)
            {
            $buses = $agent->buses->pluck('id')->toArray();
            if(count($buses)>0)
            {
                return redirect()->back()->with('error','Deletion suspended, Found buses for given agent');
            }
            $seats = ConfirmedSeat::whereIn('bus_id',$buses)
                ->whereRaw('CAST(CONCAT(STR_TO_DATE(confirmed_seats.date,"%d-%b-%Y")," ",confirmed_seats.pick_time) AS DATETIME) >= "'.now().'"')
                ->get();
            if(count($seats)>0)
            {
                return redirect()->back()->with('error','Deletion suspended, Agent\'s Bus(es) has confirmed tickets for upcoming Date and time');
            }
        }
        FCMService::send(
            $agent->fcmid,
            [
                'title' => 'Bus Booking',
                'body' => 'Your account is Deleted !',
            ]
        );
        $this->deleteAgentData($agent,$buses);
        $agent->delete();
        return redirect()->back()->with('success','Agent deleted successfully');
    }

    public function deleteAgentData(Agent $agent,$buses)
    {
        $status = BankDetail::where('agent_id',$agent->id)->delete();
        // if(!empty($buses))
        // {
        //     $status = DropPoints::whereIn('bus_id',$buses)->delete();
        //     $status = PickupPoints::whereIn('bus_id',$buses)->delete();
        //     $routes = Routes::whereIn('bus_id',$buses)->get();
        //     if(count($routes)>0)
        //     {
        //         $status = DatePrice::whereIn('route_id',$routes->pluck('id')->toArray())->delete();
        //         $routes = Routes::whereIn('id',$routes->pluck('id')->toArray())->get();
        //     }
        //     $status = ConfirmedSeat::whereIn('bus_id',$buses)->delete();
        // }

    }
}
