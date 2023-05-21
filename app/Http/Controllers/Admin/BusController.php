<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\ConfirmedSeat;
use DataTables;
use Session;


class BusController extends Controller
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
            $data = Bus::select('*')->with('agent');
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('image', function($row){
                    $btn = '<img src="'.storage_path().'app/'.$row->image.'" class="table-avatar"></img>';
                    return $btn;
                })
            ->addColumn('action', function($row){
                $btn = '';
                if($row->status=='A')
                    $btn = '<a href class="btn btn-sm btn-danger deleteModal" data-toggle="modal" data-type="D" data-target="#deleteAlert" data-id="'.$row->id.'">Delete</button></a>';
                else
                    $btn = '<a href class="btn btn-sm btn-success deleteModal" data-toggle="modal" data-type="A" data-target="#deleteAlert" data-id="'.$row->id.'">Recover</button></a>';
                    return $btn;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        }
        return view('bus.index');
    }

    public function statusChange(Request $request,Bus $bus)
    {
        if(empty($request->status))
            return redirect()->back()->with('error','Status field is required to perform this action!');

        $msg = 'Bus Recovered successfully!';

        if($request->status=='D')
        {
            $seats = ConfirmedSeat::where('bus_id',$bus->id)
                ->where('user_type','0')
                ->whereRaw('CAST(CONCAT(STR_TO_DATE(confirmed_seats.date,"%d-%b-%Y")," ",confirmed_seats.pick_time) AS DATETIME) >= "'.now().'"')
                ->get();
            if(count($seats)>0)
            {
                return redirect()->back()->with('error','Deletion suspended, Bus has confirmed tickets for upcoming Date and time');
            }
            $msg = 'Bus Deleted successfully!';
        }

        $bus->update(['status'=>$request->status]);
        return redirect()->back()->with('success',$msg);
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
