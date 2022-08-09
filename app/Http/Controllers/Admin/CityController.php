<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use DataTables;
use Session;
use DB;

class CityController extends Controller
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
            $data = City::select('*');
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                    $btn = '<div class="d-flex"> <a href="city/'.$row->id.'/edit" class="btn btn-primary btn-sm mx-2">Edit</a>';
                    $btn = $btn.'<button type="button" class="btn btn-danger" data-toggle="modal" id="deleteid" data-target="#deleteAlert" data-id="'.$row->id.'">Delete</button></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('city.index');
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
        $city = new City();
        $city->name = $request->city;
        $city->save();

        return redirect()->back()->with('success', 'successfully added !');
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
        $city = City::find($id);
        return view('city.edit', compact('city'));
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
        $city = City::find($id);
        $city->name = $request->city;
        $city->save();

        return redirect('city')->with('success', 'Updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');   
        $city = City::find(request()->id);
        $city->delete();
        
        return redirect()->back()->with('success', 'city deleted successfully !');
        
    }
}
