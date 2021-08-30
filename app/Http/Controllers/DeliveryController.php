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
        // return $request->dds;
        $date = Carbon::now();
        $awbs = Proforma::select(DB::raw('proformas.no_proforma,awbs.no_awb,DATE_FORMAT(awbs.tanggal_ds, "%d-%m-%Y") as tanggal_ds,dealers.kode_dealer,dealers.nama_dealer,dealers.dds,awbs.status,sum(proformas.koli) as koli,proformas.total_koli,proformas.status as statusp'))
                        ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                        ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')          
                        ->orderBy('awbs.no_awb','DESC')
                        ->groupBy('proformas.no_proforma');
                        // ->where('dds','DDS 1');
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
        // $awbs->get();
        // return $awbs;die;
        $awbs = $awbs->paginate(10)->appends(request()->query());
        // return $awbs;die;
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
        return $request;die;
        
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
        
        $awbs = Proforma::when($request->keyword, function ($query) use ($request) {
            $query->select(DB::raw('proformas.no_proforma,awbs.no_awb,DATE_FORMAT(awbs.tanggal_ds, "%d-%m-%Y") as tanggal_ds,dealers.kode_dealer,dealers.nama_dealer,dealers.dds,awbs.status,sum(proformas.koli) as koli,proformas.total_koli,proformas.status as statusp'))
                            ->leftjoin('awbs','proformas.no_awb','=','awbs.no_awb')
                            ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')
                            ->where('proformas.no_proforma','LIKE','%'. $request->keyword . '%')
                            ->orwhere('awbs.no_awb','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.kode_dealer','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.nama_dealer','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.dds','LIKE','%'. $request->keyword . '%')
                            ->orWhere('awbs.status','LIKE','%'. $request->keyword . '%')
                            ->orderBy('proformas.no_awb','DESC');
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
    public function image($no_awb){
        $foto = Awb::leftjoin('pengirimans','awbs.id_pengiriman','pengirimans.id')
                    ->where('awbs.no_awb',$no_awb)
                    ->first();
        if (!empty($foto)){
            $foto = $foto->foto_awb;
            return '<img src='.asset('bukti_awb/'.$foto).'>';
        } else {
            return '<img src='.asset('bukti_awb/default-image.jpg>');
        }

    }

    public function detail($no_proforma)
    {   
        //try catch sini 
        $proformas = Proforma::select(DB::raw(
                        'proformas.no_proforma,
                        awbs.no_awb,
                        dealers.nama_dealer,
                        proformas.tipe,
                        proformas.total_koli,
                        dealers.rayon,
                        dealers.dds,
                        dealers.depo,
                        proformas.keterangan,
                        proformas.status'
                        ))
                        ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                        ->leftjoin('dealers','awbs.kode_dealer','dealers.kode_dealer')
                        ->where('proformas.no_proforma',$no_proforma)
                        ->first();
        $awbs = Awb::select(DB::raw(
                        'awbs.no_awb,
                        proformas.no_proforma,
                        proformas.koli,
                        DATE_FORMAT(awbs.tanggal_ds, "%d-%m-%Y") as tanggal_ds,
                        DATE_FORMAT(pengirimans.tanggal_terima,"%d-%m-%Y") as tanggal_terima ,
                        pengirimans.waktu_terima,
                        pengirimans.penerima,
                        pengirimans.foto_awb,
                        awbs.status,
                        awbs.keterangan'
                    ))
                    ->leftjoin('pengirimans','awbs.id_pengiriman','pengirimans.id')
                    ->leftjoin('proformas','awbs.no_awb','proformas.no_awb')
                    ->where('no_proforma',$no_proforma)
                    ->get();
        // $awb_note = 
        // return $awbs;die;
        $cek = Proforma::select(DB::raw(
                        'proformas.total_koli,
                        sum(proformas.koli) as jumlah_koli'
                    ))
                    ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                    ->whereNotNull('awbs.status')
                    ->where('proformas.no_proforma',$no_proforma)
                    ->first();
        if (!empty($cek->jumlah_koli)){
            $iscomplete = $cek->total_koli - $cek->jumlah_koli;
            if ($iscomplete == 0) {
                $iscomplete = "Completed";
            } else {
                $iscomplete = "Not Completed";
            }
        } else {
            $iscomplete = "On delivery";
        }
        // return $cek;die;
        // return $iscomplete;die;
        return view('delivery.detail',compact('awbs','proformas','iscomplete'));die;

        // $no_awb = Proforma::where('no_proforma',$no_proforma)
        //                 ->pluck('no_awb');
        // $status = Awb::select('status')
        //                 ->where('no_awb',$no_awb)
        //                 ->first();
        // $status = $status->status;

        // if($status == null){
        //     $awbs = Awb::select(DB::raw(
        //                                 'awbs.no_awb,
        //                                 awbs.tanggal_ds,
        //                                 awbs.status,
        //                                 dealers.dds,
        //                                 dealers.depo,
        //                                 dealers.nama_dealer,
        //                                 dealers.rayon'
        //                                 ))
        //                 ->leftjoin('dealers','awbs.kode_dealer','dealers.kode_dealer')
        //                 ->where('no_awb',$no_awb)
        //                 ->first();          
        //     // $awbs->push('foto_awb','default-image.jpg');
        // }else{
        //     $awbs = Awb::select(DB::raw(
        //                                 'awbs.no_awb,awbs.tanggal_ds,
        //                                 awbs.status,
        //                                 awbs.keterangan,
        //                                 dealers.dds,
        //                                 dealers.depo,
        //                                 dealers.nama_dealer,
        //                                 dealers.rayon,
        //                                 pengirimans.tanggal_terima,
        //                                 pengirimans.waktu_terima,
        //                                 pengirimans.penerima,
        //                                 pengirimans.foto_awb'
        //                                 ))
        //                 ->leftjoin('dealers','awbs.kode_dealer','dealers.kode_dealer')
        //                 ->leftjoin('pengirimans','awbs.id_pengiriman','pengirimans.id')
        //                 ->where('no_awb',$no_awb)
        //                 ->first();
        // }
        // // return $awbs->status;die; 
        // if($awbs->status == null){
        //     $isdelay = "";
        // } elseif ($awbs->status == 0){
        //     $isdelay = "(Ontime)";
        // } elseif ($awbs->status == 1){
        //     $isdelay = "(Delay 1 hari)";
        // } elseif ($awbs->status == 2){
        //     $isdelay = "(Delay 2 hari)";
        // } elseif ($awbs->status == 3){
        //     $isdelay = "(Delay 3 hari)";
        // } else {
        //     $isdelay = "(Delay >3 hari)";
        // }
        // // $proformas = Proforma::select(DB::raw(
        // //     'proformas.no_proforma,
        // //     proformas.koli,
        // //     proformas.tipe'                                    
        // //     ))
        // // ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
        // // ->where('proformas.no_proforma',$no_proforma)
        // // ->get();
        // // return $awbs;die;
        // return view('delivery.detail',compact('awbs','proformas','isdelay'));
    }
}
