<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWasSelectedRequest;
use App\Http\Requests\UpdateWasSelectedRequest;
use App\Models\WasSelected;

class WasSelectedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreWasSelectedRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWasSelectedRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WasSelected  $wasSelected
     * @return \Illuminate\Http\Response
     */
    public function show(WasSelected $wasSelected)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WasSelected  $wasSelected
     * @return \Illuminate\Http\Response
     */
    public function edit(WasSelected $wasSelected)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWasSelectedRequest  $request
     * @param  \App\Models\WasSelected  $wasSelected
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWasSelectedRequest $request, WasSelected $wasSelected)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WasSelected  $wasSelected
     * @return \Illuminate\Http\Response
     */
    public function destroy(WasSelected $wasSelected)
    {
        //
    }
}
