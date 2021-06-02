<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Dealer;
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
    public function index()
    {
        $date = Carbon::now();
        $total = Awb::whereMonth('tanggal_ds',$date)
                        ->whereYear('tanggal_ds',$date)
                        ->get();
        $ontime = count($total->where('status','1'));
        $delay = count($total->where('status','>=','2'));
        $belum_terkirim = count($total->where('status',null));
        $total= count($total);
        $awbs = compact('total','ontime','delay','belum_terkirim');
        // return $awbs;die;
        
        // $tambun = Awb::select(DB::raw('awbs.status, dealers.dds, dealers.depo'))
        //                 ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')                        
        //                 ->where('dds','DDS 1')
        //                 ->where('depo','TAMBUN')
        //                 ->get();
        // $ontime = count($tambun->where('status',1));
        // $belum_terkirim = count($tambun->where('status',null));
        // $persentase_tambun = round($ontime/$belum_terkirim*100,2);
        $persentase_tambun = $this->persentaseDepo('TAMBUN','DDS 1');
        $persentase_bandung = $this->persentaseDepo('BANDUNG','DDS 2');
        $persentase_pemalang = $this->persentaseDepo('pemalang','DDS 3');
        $persentase_semarang = $this->persentaseDepo('semarang','DDS 3');
        $persentase_solo = $this->persentaseDepo('bandung','DDS 3');
        // return $persentase_bandung;die;
        //kalau tidak ada awb jadi error, fix besok(patch notes)
        
        // return $persentase_bandung;
        return view('summary.index',compact('persentase_tambun','persentase_bandung','persentase_pemalang','persentase_semarang','persentase_solo','awbs'));
    }

    public function persentaseDepo($depo,$dds){
        $date = Carbon::now();
        $depo = Awb::select(DB::raw('awbs.status, dealers.dds, dealers.depo'))
                        ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')                        
                        ->where('dds',$dds)
                        ->where('depo',$depo)
                        ->whereMonth('tanggal_ds',$date)
                        ->whereYear('tanggal_ds',$date)
                        ->get();
        $ontime = count($depo->where('status',1));
        $belum_terkirim = count($depo->where('status',null));
        if ($belum_terkirim < 1){
            $belum_terkirim =1;
        }
        $persentase_depo = round($ontime/$belum_terkirim*100,2);
        return $persentase_depo;
    }

    public function detail($kota)
    {
        // $detail = Dealer::select(DB::raw('dealers.depo','dealers.rayon'))
        //         ->leftjoin('awbs','dealers.kode_dealer','=','awbs.kode_dealer')
        //         ->where('depo',$kota)
        //         ->first();
        //         return($detail);
        // return view('summary.detail', compact('detail'));
        // return view('summary.detail');
        
        $detail = Dealer::select('dds','depo')
                        ->where('depo',$kota)
                        ->first();
        
        $rayon = Depo::where('depo',$kota)
                        ->pluck('rayon');
        $all = $this->all($rayon);
        $count = count($all);
        $ontime = $this->detailAwb($rayon,0);
        $delay1 = $this->detailAwb($rayon,1);
        $delay2 = $this->detailAwb($rayon,2);
        $delay3 = $this->detailAwb($rayon,3);
        $delay4 = $this->detailAwb($rayon,4);
        $tunda = $this->detailAwb($rayon,null);
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
    public function detailAwb($rayon,$status){
        $date = Carbon::now();
        $awb =array();
        $count = count($rayon);
        // return $count;
        for($i=0;$i<$count;$i++){
            $total = Awb::select(DB::raw('count(awbs.no_awb) as total'))
                        ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')                        
                        ->where('rayon', $rayon[$i])
                        ->where('status',$status)
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
    public function all($rayon){
        $date = Carbon::now();
        $awb =array();
        $count = count($rayon);
        // return $count;
        for($i=0;$i<$count;$i++){
            $total = Awb::select(DB::raw('count(awbs.no_awb) as total'))
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
}
