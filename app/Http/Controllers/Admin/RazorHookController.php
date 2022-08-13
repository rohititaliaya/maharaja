<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class RazorHookController extends Controller
{
    public function settlementProcessed(Request $request)
    {
        Log::info('Razor: '.json_encode($request->all()));
    }
    public function refundSettled(Request $request)
    {
        Log::info('Razor: '.json_encode($request->all()));
    }

    public function transferSettled(Request $request)
    {
        Log::info('Razor: '.json_encode($request->all()));
    }
}
