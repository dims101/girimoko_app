<?php

namespace App\Http\Controllers;
use App\Awb;

use Illuminate\Http\Request;

class TrackingController extends Controller
{
    //
    public function index(){
        return view('tracking.index');
    }

    public function update(Request $request){
        // $response = array(
        //     ['status' => 'OK'],
        //     ['status'=> 'NOT OK']
        // );
        $response = Awb::all();
        return response()->json($response);
    }
}
