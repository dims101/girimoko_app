<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dealer;
use App\Awb;
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
        $total = Awb::all();
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
        $depo = Awb::select(DB::raw('awbs.status, dealers.dds, dealers.depo'))
                        ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')                        
                        ->where('dds',$dds)
                        ->where('depo',$depo)
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
        $total = Awb::select(DB::raw('count(awbs.no_awb) as total'))
                        ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')                        
                        ->where('rayon','Tangerang-Labuan')
                        ->where('status',1)
                        ->first();
        return $total;die;
        return view('summary.detail',compact('detail'));
    }
}
