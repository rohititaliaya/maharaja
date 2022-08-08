<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBankDetailRequest;
use App\Http\Requests\UpdateBankDetailRequest;
use Illuminate\Http\Request;
use App\Models\BankDetail;
use App\Models\Bus;
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
            ->addColumn('buses', function($row){
                $buses = Bus::where('agent_id', $row->agent_id)->pluck('travels_name');
                $mstring = '';
                $cnt = 0;
                foreach($buses as $value){
                    $cnt++;
                    $mstring .=$cnt.'. '.$value.'<br>';
                }
                return $mstring;
            })
            ->addColumn('action', function($row){
                    $btn = '<a href="/agent/bank/'.$row->id.'/edit" class="edit btn btn-info btn-sm"> Edit</a>';
                    return $btn;
                })
            ->rawColumns(['buses','action'])
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
    public function store(Request $request)
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
    public function edit($id)
    {
        
        $bk = BankDetail::find($id);
        $bank = [
            'id' => $bk->id,
            'agent_id'=>$bk->agent_id,
            'account_number'=>$bk->getOriginal('account_number'),
            'banificary_name'=>$bk->getOriginal('banificary_name'),
            'ifsc_code'=>$bk->getOriginal('ifsc_code'),
            'bank_name'=>$bk->getOriginal('bank_name'),
            'city_name'=>$bk->getOriginal('city_name'),
            'mobile'=>$bk->getOriginal('mobile'),
            'email' => $bk->getOriginal('email'),
            'ac_type' => $bk->getOriginal('ac_type')
        ];
        return view('bank.edit', compact('bank'));
        //dd($bank);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBankDetailRequest  $request
     * @param  \App\Models\BankDetail  $bankDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bank = BankDetail::find($id);
        $bank->account_number = $this->encrypt($request->account_number);
        $bank->banificary_name = $this->encrypt($request->banificary_name);
        $bank->ifsc_code = $this->encrypt($request->ifsc_code);
        $bank->bank_name = $this->encrypt($request->bank_name);
        $bank->city_name = $this->encrypt($request->city_name);
        $bank->ac_type = $this->encrypt($request->ac_type);
        $bank->mobile = $this->encrypt($request->mobile);
        $bank->email = $this->encrypt($request->email);
        $bank->save();
        return redirect()->route('agent.bank')->with('success', 'bank detail updated successfully !');
        
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
    
    public function encrypt($value)
    {
          $key ='maharaja@atul#cn';
          $iv=   'encryptionIntVec';       
          $res  =   openssl_encrypt($value, 'AES-128-CBC', $key, $options=OPENSSL_RAW_DATA, $iv);
          $res2 = base64_encode($res);
          return $res2;
    }
}
