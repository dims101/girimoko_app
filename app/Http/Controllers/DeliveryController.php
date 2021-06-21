<?php

namespace App\Http\Controllers;
use DB;
use App\Awb;
use Carbon\Carbon;
use App\Proforma;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
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
    public function index(Request $request)
    {
        // return $request->status;
        $date = Carbon::now();
        $awbs = Awb::select(DB::raw('awbs.no_awb,awbs.tanggal_ds,dealers.kode_dealer,dealers.nama_dealer,dealers.dds,awbs.status'))
                        ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')          
                        ->orderBy('awbs.tanggal_ds','ASC');
        if(!empty($request->bulan)){
            // $bulan = $date->format('m');
            $bulan = $request->bulan;
            $awbs->whereMonth('tanggal_ds',$bulan);
        }
        if(!empty($request->tahun)){
            // $tahun = $date->format('Y');
            $tahun = $request->tahun;
            $awbs->whereYear('tanggal_ds',$tahun);
        }
        if(!empty($request->dds)){
            $dds = $request->dds;
            $awbs->where('dds',$dds);
        }
        
        if($request->status == null){
            
        } else if($request->status == "delay"){          
            $awbs->whereNull('status');
        } else {
            $status = $request->status;            
            $awbs->where('status',$status);
        }
        
        $awbs = $awbs->paginate(10)->appends(request()->query());
        return view('delivery.index',compact('awbs'));
         
    }
    public function cari(Request $request){

        // $bulan = $request->bulan;
        // $tahun = $request->tahun;
        // $dds = $request->dds;
        // $status = $request->status; 
        // $search = $request->cari;
        
        $awbs = Awb::when($request->keyword, function ($query) use ($request) {
            $query->select(DB::raw('awbs.no_awb, awbs.tanggal_ds, dealers.kode_dealer, dealers.nama_dealer, dealers.dds, awbs.status'))
                            ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')
                            ->where('awbs.no_awb','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.kode_dealer','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.nama_dealer','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.dds','LIKE','%'. $request->keyword . '%')
                            ->orWhere('awbs.status','LIKE','%'. $request->keyword . '%')
                            ->orderBy('awbs.tanggal_ds','ASC');
        })->paginate(10);    
        //ini apa    
        $awbs->appends($request->only('keyword'));            
    
    return view('delivery.index',compact('awbs')); 

    }


    // public function liveFilter(Request $request)
    // {   
    //     $dealer = $request->dealer;
    //     $dds = $request->dds;
    //     $status = $request->status; 

    //     $awbs = Awb::select(DB::raw('awbs.no_awb,awbs.no_awb,dealers.kode_dealer,dealers.nama_dealer,dealers.dds,awbs.status'))
    //                 ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')
    //                 ->where('kode_dealer','LIKE',"%{$dealer}%")
    //                 ->where('dds','LIKE',"%{$dds}%")
    //                 ->where('status','LIKE',"%{$status}%")
    //                 // ->orwhere('project_no','LIKE',"%{$search}%")
    //                 ->paginate(8); ;
    //     return view('delivery.index',['awbs'=>$awbs]);
        
    // }
    


    public function detail($no_awb)
    {   
        //try catch sini 
        $status = Awb::select('status')
                        ->where('no_awb',$no_awb)
                        ->first();
        $status = $status->status;

        if($status == null){
            $awbs = Awb::select(DB::raw(
                                        'awbs.no_awb,
                                        awbs.tanggal_ds,
                                        awbs.status,
                                        dealers.dds,
                                        dealers.depo,
                                        dealers.nama_dealer,
                                        dealers.rayon'
                                        ))
                        ->leftjoin('dealers','awbs.kode_dealer','dealers.kode_dealer')
                        ->where('no_awb',$no_awb)
                        ->first();          
            // $awbs->push('foto_awb','default-image.jpg');
        }else{
            $awbs = Awb::select(DB::raw(
                                        'awbs.no_awb,awbs.tanggal_ds,
                                        awbs.status,
                                        awbs.keterangan,
                                        dealers.dds,
                                        dealers.depo,
                                        dealers.nama_dealer,
                                        dealers.rayon,
                                        pengirimans.tanggal_terima,
                                        pengirimans.waktu_terima,
                                        pengirimans.penerima,
                                        pengirimans.foto_awb'
                                        ))
                        ->leftjoin('dealers','awbs.kode_dealer','dealers.kode_dealer')
                        ->leftjoin('pengirimans','awbs.id_pengiriman','pengirimans.id')
                        ->where('no_awb',$no_awb)
                        ->first();
        }
        // return $awbs->status;die; 
        if($awbs->status == null){
            $isdelay = "";
        } elseif ($awbs->status == 0){
            $isdelay = "(Ontime)";
        } elseif ($awbs->status == 1){
            $isdelay = "(Delay 1 hari)";
        } elseif ($awbs->status == 2){
            $isdelay = "(Delay 2 hari)";
        } elseif ($awbs->status == 3){
            $isdelay = "(Delay 3 hari)";
        } else {
            $isdelay = "(Delay >3 hari)";
        }
        $proformas = Proforma::select(DB::raw(
            'proformas.no_proforma,
            proformas.koli,
            proformas.tipe'                                    
            ))
        ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
        ->where('proformas.no_awb',$no_awb)
        ->get();
        // return $awbs;die;
        return view('delivery.detail',compact('awbs','proformas','isdelay'));
    }
}
