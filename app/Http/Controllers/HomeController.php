<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Awb;
use DB;

class HomeController extends Controller
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
        $awbs = Awb::whereMonth('tanggal_ds',$date)
                        ->whereYear('tanggal_ds',$date)
                        ->get();
        $total = count($awbs);
        $terkirim = round(count($awbs->whereNotNull('status'))/$total*100,1);
        $tertunda = round(count($awbs->whereNull('status'))/$total*100,1);   
        
        function depo($depo){
            $date = Carbon::now();//cari biar bisa panggil dari luar
            $awb_dds = Awb::select(DB::raw('count(awbs.no_awb) as jumlah'))
                                ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')
                                ->where('depo',$depo)
                                ->whereMonth('tanggal_ds',$date)
                                ->whereYear('tanggal_ds',$date)
                                ->whereNotNull('status') 
                                //toggle status jangan lupa
                                ->groupBy('dealers.depo')
                                ->pluck('jumlah');
            if(empty(count($awb_dds))){
                return 0;
            } else {
                return $awb_dds[0];

            }
        }
        $tambun = depo("TAMBUN");
        $tambun = round($tambun/$total*100,1);
        $bandung = depo("BANDUNG");
        $bandung = round($bandung/$total*100,1);
        $purwokerto = depo("PURWOKERTO");
        $purwokerto = round($purwokerto/$total*100,1);
        $semarang = depo("SEMARANG");
        $semarang = round($semarang/$total*100,1);
        $solo = depo("SOLO");
        $solo = round($solo/$total*100,1);
        $awb_dds = [$tambun,$bandung,$purwokerto,$semarang,$solo];
        
        
        $awb_tertunda = Awb::select(DB::raw('tanggal_ds as name, count(no_awb) as y'))
        //belum ada filter bulan ini
                                ->whereNull('status')
                                ->groupBy('tanggal_ds')
                                ->get();
        $data = compact('total','tertunda','terkirim','awb_tertunda');
        return view('dashboard.index',compact('data','awb_dds'));
    }
}
