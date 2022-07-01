<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Routes;
use DataTables;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Routes::select('*')->with('bus')->with('to')->with('from');
            return DataTables::of($data)
            ->addIndexColumn()
            // ->addColumn('action', function($row){
                //     $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm">View</a>';
                //     $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
                //     $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';
                //     return $btn;
                // })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('route.index');
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
