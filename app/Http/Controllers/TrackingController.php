<?php

namespace App\Http\Controllers;
use App\Awb;
use App\Tracking;
use DB;
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
        $last = Tracking::pluck('id')
                ->last();
        $response = Awb::select(
        DB::raw('awbs.no_awb,awbs.tanggal_ds,dealers.kode_dealer,dealers.nama_dealer,dealers.dds,trackings.lokasi'))
        ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')      
        ->leftjoin('trackings','awbs.no_ds','=','trackings.ds') 
        ->where('no_ds',$request->ds)
        ->where('trackings.id',$last)
        ->get();
        // return $last;die;
        return response()->json($response);
    }
}
