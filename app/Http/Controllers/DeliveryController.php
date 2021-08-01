<?php

namespace App\Http\Controllers;
use DB;
use App\Awb;
use App\Dealer;
use App\Pengiriman;
use Carbon\Carbon;
use App\Proforma;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Intervention\Image\ImageManagerStatic as Image;
use DateTime;
use DatePeriod;
use DateInterval;

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

    public function edit($no_awb){
        $awbs = Awb::where('no_awb', $no_awb)
                    ->first();
        $nama_dealer = Dealer::where('kode_dealer',$awbs->kode_dealer)
                        ->pluck('nama_dealer');
        $nama_dealer = $nama_dealer[0]; 
        $pengiriman = Pengiriman::where('id',$awbs->id_pengiriman)
                        ->first();
        if(!$pengiriman){
            $pengiriman  = new \stdClass();
            $pengiriman->no_kendaraan ='';
            $pengiriman->id =null;
            $pengiriman->tanggal_terima ='';
            $pengiriman->waktu_terima ='';
            $pengiriman->penerima ='';
            $pengiriman->foto_awb =null;
        } 
        // return $pengiriman;die;
        return view('delivery.edit', compact('awbs','nama_dealer','pengiriman'));
    }

    public function store(Request $request){
        // return $request;die;
        
        Pengiriman::where('id',$request->id)->update([
            'no_kendaraan'=> $request->no_kendaraan,
            // 'tanggal_terima'=> $request->tanggal_terima,
            // 'waktu_terima'=> $request->waktu_terima,
            'penerima'=> $request->penerima,
            'foto_awb'=> $file_name,
        ]);
        if($request->file('foto_awb')<>null){
            $file = Image::make($request->foto_awb)->stream('jpg',100);
            $file_name = $request->no_awb .'-'.$request->tanggal_terima . '.jpg';
            file_put_contents(public_path('bukti_awb/'.$file_name), $file);
        }
        $awbs = Awb::where('no_awb', $request->no_awb)
                    ->first();
        $target = Dealer::select('target')
                    ->where('kode_dealer',$request->kode_dealer)
                    ->first();
        $tanggal_terima = $request->tanggal_terima;
        $waktu_terima = $request->waktu_terima;
        // return $tanggal_terima;die;
        $begin = new DateTime($awbs->tanggal_ds);
        $end = new DateTime($tanggal_terima);

        $daterange     = new DatePeriod($begin, new DateInterval('P1D'), $end);
        //mendapatkan range antara dua tanggal dan di looping
        $i=0;
        $x     =    0;
        $end     =    1;

        foreach($daterange as $date){
            $daterange     = $date->format("Y-m-d");
            $datetime     = DateTime::createFromFormat('Y-m-d', $daterange);

            //Convert tanggal untuk mendapatkan nama hari
            $day         = $datetime->format('D');

            //Check untuk menghitung yang bukan hari sabtu dan minggu
            if($day!="Sun") {
                //echo $i;
                $x    +=    $end-$i;
                
            }
            $end++;
            $i++;
        }  
        $status = $x-$target;
        if($status == -1){
            $status = 0;
        }
        if ($status >3){
            $status = 4;
        }
        // return $status;
        Awb::where('no_awb',$request->no_awb)
                ->update([
                    'status'=>$status,
                    'keterangan'=>$request->keterangan,
                ]);
        return redirect()->back()->with('message','Data berhasil diubah');
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
