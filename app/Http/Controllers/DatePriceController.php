<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDatePriceRequest;
use App\Http\Requests\UpdateDatePriceRequest;
use App\Models\DatePrice;

class DatePriceController extends Controller
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
     * @param  \App\Http\Requests\StoreDatePriceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDatePriceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DatePrice  $datePrice
     * @return \Illuminate\Http\Response
     */
    public function show(DatePrice $datePrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DatePrice  $datePrice
     * @return \Illuminate\Http\Response
     */
    public function edit(DatePrice $datePrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDatePriceRequest  $request
     * @param  \App\Models\DatePrice  $datePrice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDatePriceRequest $request, DatePrice $datePrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DatePrice  $datePrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(DatePrice $datePrice)
    {
        //
    }
}
