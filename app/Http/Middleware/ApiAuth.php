<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Api;
use App\Models\ActiveSession;
use Illuminate\Http\Request;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->header('api-key')){
            $api = Api::where('api_key',$request->header('api-key'))->first();
            if(!empty($api))
            {
                $session =  ActiveSession::where('user_id',$api->user_id)->orderBy('updated_at','desc')->first();
                if($session->active==1){
                    // if($session->updated_at->diffInSeconds()>1800)
                    // {
                    //  ActiveSession::create([
                    //      'user_id' => $session->user_id,
                    //      'active' => '0']);
                    //  $api->delete();
                    //  return response()->json(['message' => 'Logout because of inactivity, please login again', 'status' => 0, 'response'=>10],200);
                    // }
                    // else
                    // {
                        $session->update([
                            'updated_at' => time()]);
                        return $next($request);
                    // }
                }
                else
                {
                    return response()->json(['message'=>'You are logged out, To perform this action you must have to login','status'=>0, 'response'=>10],200);
                }
            }
            else
            {
                return response()->json(['message'=>'Invalid App_key found', 'status' => 0, 'response'=>10],200);
            }
        }
        return response()->json(['message'=>'Not Authorized', 'status' => 0, 'response'=>10],200);
    }
}
