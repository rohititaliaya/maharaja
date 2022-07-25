<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBankDetailRequest;
use App\Http\Requests\UpdateBankDetailRequest;
use Illuminate\Http\Request;
use App\Models\BankDetail;
use DataTables;
use App\Services\FCMService;
use Session;

class BankDetailController extends Controller
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
            $data = BankDetail::select('*')->with('agent');
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
        return view('bank.index');
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
     * @param  \App\Http\Requests\StoreBankDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankDetail  $bankDetail
     * @return \Illuminate\Http\Response
     */
    public function show(BankDetail $bankDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankDetail  $bankDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(BankDetail $bankDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBankDetailRequest  $request
     * @param  \App\Models\BankDetail  $bankDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankDetailRequest $request, BankDetail $bankDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankDetail  $bankDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankDetail $bankDetail)
    {
        //
    }
}
