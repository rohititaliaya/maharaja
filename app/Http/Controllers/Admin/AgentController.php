<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use DataTables;

class AgentController extends Controller
{
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
                    if ($row->status == "0") {
                        $btn = '<a href="/agent/agent-approve/'.$row->id.'" class="edit btn btn-info btn-sm"> Approve</a>';
                    }else{
                        $btn = '<a href="/agent/agent-dis-approve/'.$row->id.'" class="edit btn btn-danger btn-sm">Dis-Approve</a>';
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

        return redirect()->back()->with('success', 'request approved successfully');
    }

    public function DisApprove(Request $request)
    {
        $agent = Agent::find($request->id);
        $agent->status = "0";
        $agent->save();

        return redirect()->back()->with('success', 'request approved successfully');
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
