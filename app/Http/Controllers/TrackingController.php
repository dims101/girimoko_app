<?php

namespace App\Http\Controllers;
use App\Awb;
use App\Tracking;
use Auth;
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
        // $last = Tracking::pluck('id')
        //         ->last();
        $response = Awb::select(
        DB::raw('awbs.no_awb,date_format(trackings.created_at ,"%d/%m/%Y %H:%i") as tanggal_ds,dealers.kode_dealer,dealers.nama_dealer,dealers.dds,trackings.lokasi'))
        ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')      
        ->leftjoin('trackings','awbs.no_awb','=','trackings.awb') 
        ->where('no_ds',$request->ds)
        // ->where('trackings.id',$last)
        ->get();
        // return $last;die;
        return response()->json($response);
    }

    public function updateLokasi(Request $request)
    {
        $user = Auth::user();
        $awbs = Awb::where('no_ds',$request->ds)
                    ->pluck('no_awb');
        foreach ($awbs as $awb){
            Tracking::create([
                'awb' => $awb,
                'id_user' => $user->username,
                'lokasi' => $user->name,
                'comment' => 'SHIPMENT RECEIVED BY GIRIMOKO OFFICER AT'
            ]);
        }
        

        return redirect('/tracking')->with('message','Lokasi berhasil di-update');
    }
}
