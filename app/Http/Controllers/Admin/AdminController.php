<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminPolicy;
use App\Models\Bus;
use App\Models\Setting;
use App\Models\Agent;
use App\Models\ConfirmedSeat;
use App\Models\User;
use Session;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     if(Session::get("is_loggedin") == false && empty(Session::get('is_loggedin'))) {
    //         // dd(Session::get("is_loggedin"));
    //         return view('login.login');
    //     }
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Session::has('is_loggedin'))
        {
            return view('login.login');
        }
        $buses = Bus::all()->count();
        $agents = Agent::all()->count();
        $users = User::all()->count();
        $cbs = ConfirmedSeat::all()->count();
        $array = [
            'total_buses' => $buses,
            'total_agents' =>$agents,
            'total_users' => $users,
            'current_bookings' => $cbs
        ];
        // return $array;
        return view('welcome', compact('array'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('login.login');
    }

    public function loginpost(Request $request)
    {
        $set = Setting::find(1);
        $setting = json_decode($set->values);
        if($request->email == $setting->admin_user && $request->password == $setting->admin_pass){
            Session::put('is_loggedin', 'admin');
            return redirect()->route('dashboard')->with('success', 'Login successfully !');
        }
        return redirect()->back()->with('danger','Invalid credentials !');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success','logout successfully !');
    }

    public function privacy()
    {
        $set = Setting::find(1);
        $m = json_decode($set->values);
        $array = [
            'email' => $m->email,
            'mobile' => $m->mobile,
            'privacy_policy'=> $m->privacy_policy,
            'razorpay_apikey'=> $m->razorpay_apikey,
        ];
        return $array;
    }
    public function getPolicy(Request $request)
    {
        if(!Session::has('is_loggedin'))
        {
            return view('login.login');
        }
        $sets = Setting::find(1);
        $set = json_decode($sets->values);
        return view('policy.policy',['setting' => $set]);
    }

    public function privacyPolicy(Request $request)
    {
        $set = Setting::find(1);
        $set->type = 'policy';
        $set->values = json_encode($request->toArray());
        $set->save();
        return redirect()->back()->with('success', 'Updated successfully !');
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
