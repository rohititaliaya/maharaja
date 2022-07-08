<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminPolicy;


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
        $admin = config('AdminPolicy.id');
        $array = [
            'email' => config('AdminPolicy.email'),
            'mobile' => config('AdminPolicy.mobile'),
            'privacy_policy'=>config('AdminPolicy.privacy_policy')
        ];
        return $array;
    }
    public function getPolicy(Request $request)
    {
        return view('policy.policy');
    }

    public function privacyPolicy(Request $request)
    {
        $email = $request->email;
        $array = config('AdminPolicy');
        $array['email'] = $email;
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
