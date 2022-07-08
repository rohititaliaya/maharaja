<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminPolicy;
use App\Models\Setting;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
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
        if($request->email == config('Admin.email') && $request->password == config('Admin.password')){
            return redirect()->route('dashboard')->with('success', 'Login successfully !');
        }
        return redirect()->back()->with('danger','Invalid credentials !');
    }

    public function logout()
    {
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
