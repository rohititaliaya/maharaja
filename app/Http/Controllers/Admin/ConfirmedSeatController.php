<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConfirmedSeat;
use App\Models\Bus;
use DataTables;
use Session;
use Carbon\Carbon;
 
class ConfirmedSeatController extends Controller
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
        $d1 = null;
        if(request()->date){
            $createdAt = Carbon::parse(request()->date);
            $d1 = $createdAt->format('d-M-Y');
        }
        $ps = $request->get('payment_status');
        $s = $request->get('status');
        $b = $request->get('bus_id');
        $buses = Bus::select('id','travels_name','plat_no')->get();
        if ($request->ajax()) {
            $data = ConfirmedSeat::select('*');
            return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($ps,$s,$b,$d1,$request) {
                if ($ps=='1' || $ps=='0') {
                    $instance->where('payment_status', $ps);
                }
                if ($s=='1' || $s=='0') {
                    $instance->where('status', $s);
                }
                if (!is_null($b) || $b !="") {
                    $instance->where('bus_id', $b);
                }
                if (!is_null($d1) || $d1!="") {
                    $instance->where('date', $d1);
                }
            })
            ->addColumn('bus_name', function($row){
                $bus = Bus::find($row->bus_id);
                return $bus->travels_name;
            })
            ->addColumn('seatNo', function($row){
                    $m = implode(' & ', json_decode($row->seatNo));
                    return $m;
                })->addColumn('payment_status', function($row){
                    if ($row->payment_status == "1") {
                        $m = "<span class='badge bg-success'>success</span>";
                    }
                    if ($row->payment_status == "0") {
                        $m = "<span class='badge bg-danger'>failed</span>";
                    }
                    return $m;
                })
                ->addColumn('seat_status', function($row){
                    if ($row->status == "1") {
                        $m = "<span class='badge bg-success'>confirmed</span>";
                    }
                    if ($row->status == "0") {
                        $m = "<span class='badge bg-danger'>cancelled</span>";
                    }
                    return $m;
                })
                ->rawColumns(['bus_name','seatNo','payment_status','seat_status'])
                ->make(true);
        }
        return view('confirmed_seat.index',compact('buses'));
        
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
