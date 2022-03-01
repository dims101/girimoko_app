<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Dealer;
use App\Proforma;
use App\Awb;
use App\Depo;
use DB;

class SummaryController extends Controller
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
        $date = Carbon::now();
        if(empty($request->bulan)){
            $bulan = $date->format('m');
        } else {
            $bulan = $request->bulan;
        }
        
        if(empty($request->tahun)){
            $tahun = $date->year;
        } else {
            $tahun = $request->tahun;
        }
        if(!empty($request->bulan) or !empty($request->tahun)){            
            $stringdate = $tahun .'-'.$bulan . '-' . '01';
            $date = new Carbon($stringdate);
        }
        $total = Proforma::select(DB::raw('proformas.no_proforma,awbs.no_awb,proformas.status as statusP,awbs.status'))
                        ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                        ->whereMonth('awbs.tanggal_ds',$date)
                        ->whereYear('awbs.tanggal_ds',$date)
                        ->get();
        // return $total;die;
        $ontime = count($total->where('status','0'));
        $delay = count($total->where('status','>=','1'));
        $belum_terkirim = count($total->where('status',null));
        $total= count($total);
        $proformas = compact('total','ontime','delay','belum_terkirim');
        // return $awbs;die;
        
        // $tambun = Awb::select(DB::raw('awbs.status, dealers.dds, dealers.depo'))
        //                 ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')                        
        //                 ->where('dds','DDS 1')
        //                 ->where('depo','TAMBUN')
        //                 ->get();
        // $ontime = count($tambun->where('status',1));
        // $belum_terkirim = count($tambun->where('status',null));
        // $persentase_tambun = round($ontime/$belum_terkirim*100,2);
        $persentase_tambun = $this->persentaseDepo('TAMBUN','DDS 1',$date);
        $persentase_tambun2 = $this->persentaseDepo('TAMBUN','DDS 2',$date);
        $persentase_bandung = $this->persentaseDepo('BANDUNG','DDS 2',$date);
        $persentase_pemalang = $this->persentaseDepo('pemalang','DDS 3',$date);
        $persentase_semarang = $this->persentaseDepo('semarang','DDS 3',$date);
        $persentase_solo = $this->persentaseDepo('solo','DDS 3',$date);
        //prob6-7
        // return $persentase_bandung;die;
        //kalau tidak ada awb jadi error, fix besok(patch notes)
        
        // return $persentase_bandung;
        return view('summary.index',compact('persentase_tambun','persentase_tambun2','persentase_bandung','persentase_pemalang','persentase_semarang','persentase_solo','proformas'));
    }

    public function persentaseDepo($depo,$dds,$date){
        // $date = Carbon::now();
        $depo = Proforma::select(DB::raw('proformas.no_proforma,awbs.status as status, dealers.dds, dealers.depo'))
                        ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                        ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')                        
                        ->where('dds',$dds)
                        ->where('depo',$depo)
                        ->whereMonth('tanggal_ds',$date)
                        ->whereYear('tanggal_ds',$date)
                        ->get();
        $terkirim = count($depo->where('status','!=', null));
        $total = count($depo);
        if ($total < 1){
            $total =1;
        }
        $persentase_depo = round($terkirim/$total*100,1);
        return $persentase_depo;
    }

    public function detail($dds,$kota,Request $request)
    {
        $date = Carbon::now();
        if(empty($request->bulan)){
            $bulan = $date->format('m');
        } else {
            $bulan = $request->bulan;
        }
        
        if(empty($request->tahun)){
            $tahun = $date->year;
        } else {
            $tahun = $request->tahun;
        }
        if(!empty($request->bulan) or !empty($request->tahun)){            
            $stringdate = $tahun .'-'.$bulan . '-' . '01';
            $date = new Carbon($stringdate);
        }
        // $detail = Dealer::select(DB::raw('dealers.depo','dealers.rayon'))
        //         ->leftjoin('awbs','dealers.kode_dealer','=','awbs.kode_dealer')
        //         ->where('depo',$kota)
        //         ->first();
        //         return($detail);
        // return view('summary.detail', compact('detail'));
        // return view('summary.detail');
        $dds = chunk_split($dds, 3, " ");
        // return $dds ;die;
        $detail = Dealer::select('dds','depo')
                        ->where('depo',$kota)
                        ->where('dds',$dds)
                        ->first();
        // return $detail;die;
        $rayon = Depo::where('depo',$kota)
                        ->where('dds',$dds)
                        ->pluck('rayon');
        $all = $this->all($rayon,$date);
        // return $all;die;
        $count = count($all);
        $ontime = $this->detailAwb($rayon,0,$date);
        $delay1 = $this->detailAwb($rayon,1,$date);
        $delay2 = $this->detailAwb($rayon,2,$date);
        $delay3 = $this->detailAwb($rayon,3,$date);
        $delay4 = $this->detailAwb($rayon,4,$date);
        $tunda = $this->detailAwb($rayon,null,$date);
        $data = [
            'rayon' => $rayon,
            'all' => $all,
            'ontime' => $ontime,
            'delay1' => $delay1,
            'delay2' => $delay2,
            'delay3' => $delay3,
            'delay4' => $delay4,
            'tunda' => $tunda,
        ];
        // return $data['all'];die; 
        // $total = Awb::select(DB::raw('count(awbs.no_awb) as total'))
        //                 ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')                        
        //                 ->where('rayon', $rayon[9])
        //                 ->where('status',1)
        //                 ->first();
        //                 return $total;die; 
        return view('summary.detail',compact('detail','data','count'));
    }
    public function detailAwb($rayon,$status,$date){
        // $date = Carbon::now();
        $awb =array();
        $count = count($rayon);
        // return $count;
        for($i=0;$i<$count;$i++){
            $total = Proforma::select(DB::raw('count(proformas.no_proforma) as total'))
                        ->leftjoin('awbs','proformas.no_awb','=','awbs.no_awb')                        
                        ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')                        
                        ->where('rayon', $rayon[$i])
                        ->where('awbs.status',$status)
                        ->whereMonth('tanggal_ds',$date)
                        ->whereYear('tanggal_ds',$date)
                        ->first();
            $total = $total->total;
            // if(is_null($total)){
            //     $total = 0;
            // }
            $awb[] = $total;
        }
        return $awb;
        
    }
    public function all($rayon,$date){
        // $date = Carbon::now();
        $awb =array();
        $count = count($rayon);
        // return $count;
        for($i=0;$i<$count;$i++){
            $total = Proforma::select(DB::raw('count(awbs.no_awb) as total'))
                        ->leftjoin ('awbs','proformas.no_awb','awbs.no_awb')
                        ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')                        
                        ->where('rayon', $rayon[$i])
                        ->whereMonth('tanggal_ds',$date)
                        ->whereYear('tanggal_ds',$date)
                        // ->where('status',$status)
                        ->first();
            $total = $total->total;
            // if(is_null($total)){
            //     $total = 0;
            // }
            $awb[] = $total;
        }
        return $awb;
        
    }
    public function rayon($dds,$depo,$rayon,Request $request){
        $date = Carbon::now();
        if(empty($request->bulan)){
            $bulan = $date->format('m');
        } else {
            $bulan = $request->bulan;
        }
        
        if(empty($request->tahun)){
            $tahun = $date->year;
        } else {
            $tahun = $request->tahun;
        }
        if(!empty($request->bulan) or !empty($request->tahun)){            
            $stringdate = $tahun .'-'.$bulan . '-' . '01';
            $date = new Carbon($stringdate);
        }
        $detail = Proforma::select(DB::raw(
                        'proformas.no_proforma,
                        proformas.no_awb,
                        dealers.nama_dealer,
                        dealers.alamat,
                        awbs.status'
                        ))
                        ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                        ->leftjoin('dealers','awbs.kode_dealer','dealers.kode_dealer')
                        ->leftjoin('pengirimans','awbs.id_pengiriman','pengirimans.id')
                        ->where('dealers.dds',$dds)
                        ->where('dealers.depo',$depo)
                        ->where('dealers.rayon',$rayon)
                        ->whereMonth('tanggal_ds',$date)
                        ->whereYear('tanggal_ds',$date);
                        // ->get();
        $detail = $detail->paginate(10)->appends(request()->query());
        // return $detail;die;
        return view('summary.rayon',compact('detail','dds','depo','rayon'));
    }

    public function cariRayon($dds,$depo,$rayon,Request $request){
        
        $date = Carbon::now();
        if(empty($request->bulan)){
            $bulan = $date->format('m');
        } else {
            $bulan = $request->bulan;
        }
        
        if(empty($request->tahun)){
            $tahun = $date->year;
        } else {
            $tahun = $request->tahun;
        }
        if(!empty($request->bulan) or !empty($request->tahun)){            
            $stringdate = $tahun .'-'.$bulan . '-' . '01';
            $date = new Carbon($stringdate);
        }
        // return $dds;die;
        $detail = Proforma::when($request->keyword, function ($query) use ($request) {
            global $dds;
            global $depo;
            global $rayon;
            global $date;
            $query->select(DB::raw(
                        'proformas.no_proforma,
                        proformas.no_awb,
                        dealers.nama_dealer,
                        dealers.alamat,
                        awbs.status'
                        ))
                        ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                        ->leftjoin('dealers','awbs.kode_dealer','dealers.kode_dealer')
                        ->leftjoin('pengirimans','awbs.id_pengiriman','pengirimans.id')
                        ->where('dealers.dds',$dds)
                        ->where('dealers.depo',$depo)
                        ->where('dealers.rayon',$rayon)
                        ->whereMonth('tanggal_ds',$date)
                        ->whereYear('tanggal_ds',$date)
                        ->orWhere('proformas.no_proforma','LIKE','%'. $request->keyword . '%')
                        ->orWhere('proformas.no_awb','LIKE','%'. $request->keyword . '%')
                        ->orWhere('dealers.nama_dealer','LIKE','%'. $request->keyword . '%')
                        ->orWhere('dealers.alamat','LIKE','%'. $request->keyword . '%')
                        ->orWhere('awbs.status','LIKE','%'. $request->keyword . '%');
        })->paginate(10);    
        //ini apa    
        $detail->appends(request()->query());  
        // return $detail;die;
        return view('summary.rayon',compact('detail','dds','depo','rayon'));
    }
}
