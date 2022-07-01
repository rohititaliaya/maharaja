<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAgentRequest;
use App\Http\Requests\UpdateAgentRequest;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\FCMService;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ['flag'=>true,'data'=>Agent::all()];
    }

    public function checkAgent(Request $request)
    {
        $agent = Agent::where('mobile',$request->mobile)->select(['id','name','mobile','fcmid','status'])->first();
        if(!empty($agent)) {
            $agent->fcmid = $request->fcmid;
            $agent->save();
            return response()->json(['flag'=>true,'message'=>'success', 'data'=>$agent]);
        }
        
        return response()->json(['flag'=>false, 'message'=>'agent not found']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(request()->fcm_token);
        FCMService::send(
            request()->fcm_token,
           [ 
                'title' => "Mario",
                'body' => 'bus booking'
            ]
        );
        return response()->json(['flag'=>true,'message'=>'notification Successfully']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAgentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'name'=>'required',
            'mobile' => 'required|unique:agents,mobile'
        ]);
        if ($validator->fails()) {
            $error = [];
            $error['flag']=false;
            foreach ($validator->errors()->toArray() as $key => $value) {
                $error['error'] = $value[0];
            }
            return response()->json($error);
        }
        $agent = new Agent();
        $agent->name =  $request->name;
        $agent->mobile =  $request->mobile;
        $agent->fcmid = $request->fcmid;    
        $agent->save();
        FCMService::send(
            $agent->fcmid,
            [
                'title' => 'Bus Booking',
                'body' => 'registration successfully !',
            ]
        );
        return response()->json(['flag'=>true,'message'=>'Record Created Successfully','data'=>$agent]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function show(Agent $agent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function edit(Agent $agent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAgentRequest  $request
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAgentRequest $request, Agent $agent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        //
    }
}
