<?php

namespace App\Http\Controllers;
use DB;
use App\Awb;
use App\Proforma;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('delivery.index');
        // $awbs = Awb::all();
        $bulan = 01;
        $tahun = 1970;
        $awbs = Awb::select(DB::raw('awbs.no_awb,awbs.no_awb,dealers.kode_dealer,dealers.nama_dealer,dealers.dds,awbs.status'))
                        ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')                        
                        ->whereMonth('tanggal_ds',date('m',strtotime($bulan)))
                        ->whereYear('tanggal_ds',date('Y',strtotime($tahun)))
                        ->get();
        // dd($awbs);
        return view('delivery.index',compact('awbs'));
    }

    public function detail($no_awb)
    {   
        //try catch sini 
        $status = Awb::select('status')
                        ->where('no_awb',$no_awb)
                        ->first();
        $status = $status->status;

        if($status != 1){
            $awbs = Awb::select(DB::raw(
                                        'awbs.no_awb,awbs.tanggal_ds,
                                        dealers.dds,
                                        dealers.depo,
                                        dealers.nama_dealer,
                                        dealers.rayon'
                                        ))
                        ->leftjoin('dealers','awbs.kode_dealer','dealers.kode_dealer')
                        ->where('no_awb',$no_awb)
                        ->first();
            $proformas = [];
            return view('delivery.detail',compact('awbs','proformas'));
        }else{
            $awbs = Awb::select(DB::raw(
                                        'awbs.no_awb,awbs.tanggal_ds,
                                        dealers.dds,
                                        dealers.depo,
                                        dealers.nama_dealer,
                                        dealers.rayon,
                                        pengirimans.tanggal_terima,
                                        pengirimans.waktu_terima,
                                        pengirimans.penerima'
                                        
                                        ))
                        ->leftjoin('dealers','awbs.kode_dealer','dealers.kode_dealer')
                        ->leftjoin('pengirimans','awbs.id_pengiriman','pengirimans.id')
                        ->where('no_awb',$no_awb)
                        ->first();
                        // return $awbs;die;
            $proformas = Proforma::select(DB::raw(
                                    'proformas.no_proforma,
                                    proformas.koli,
                                    proformas.tipe,
                                    awbs.keterangan'                                    
                                    ))
                                ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                                ->where('proformas.no_awb',$no_awb)
                                ->get();
                                // return $proformas;
            return view('delivery.detail',compact('awbs','proformas'));
        }
    }
}
