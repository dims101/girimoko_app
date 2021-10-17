<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Awb;
use App\Proforma;
use App\User;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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
    public function index(Request $request)
    {
        // if(auth()->user()->level == 'user' or auth()->user()->level == 'Super Admin'){
            // return $request->bulan;die;
            $now = Carbon::now();
            if(empty($request->bulan)){
                $bulan = $now->format('m');                
            } else {
                $bulan = $request->bulan;
            }
            if(empty($request->tahun)){
                $tahun = $now->year;                
            }else {
                $tahun = $request->tahun;
            }
            // return $bulan;die;
            if(!empty($request->bulan or !empty($request->tahun))){
                $stringdate = $tahun .'-'.$bulan . '-' . '01';
                $date = new Carbon($stringdate);
            } else {
                $date = Carbon::now();
            }
            
            $complete = Proforma::select(DB::raw('proformas.no_proforma,(sum(koli) - total_koli) as delivery'))
                            ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                            ->whereMonth('awbs.tanggal_ds',$date)
                            ->whereYear('awbs.tanggal_ds',$date)
                            ->whereNotNull('proformas.status')
                            ->having('delivery','=',0)
                            // ->where('proformas.status','1')
                            ->groupBy('proformas.no_proforma')->get()->count();
            $notcomplete = Proforma::select(DB::raw('proformas.no_proforma,(sum(koli) - total_koli) as delivery'))
                            ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                            ->whereMonth('awbs.tanggal_ds',$date)
                            ->whereYear('awbs.tanggal_ds',$date)
                            // ->where('proformas.status','2')                            
                            ->having('delivery','<>',0)
                            ->groupBy('proformas.no_proforma')->get()->count();
            $ondelivery = Proforma::leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                            ->whereMonth('awbs.tanggal_ds',$date)
                            ->whereYear('awbs.tanggal_ds',$date)
                            ->whereNull('proformas.status')->get()->count();
            
            $total = $complete+$notcomplete+$ondelivery;
            if ($total == 0){
                $total =1;
            }
            // return $complete;
            $complete = round($complete/$total*100,1);
            $notcomplete = round($notcomplete/$total*100,1);   
            $ondelivery = round($ondelivery/$total*100,1);   
            
            function depo($depo,$dds,$date){
                
                $proforma_dds = Proforma::select(DB::raw('count(proformas.no_proforma) as jumlah'))
                                    ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                                    ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')
                                    ->where('depo',$depo)
                                    ->where('dds',$dds)
                                    ->whereMonth('awbs.tanggal_ds',$date)
                                    ->whereYear('awbs.tanggal_ds',$date)
                                    ->whereNotNull('awbs.status') 
                                    //toggle status jangan lupa
                                    ->groupBy('dealers.depo')
                                    ->pluck('jumlah');
                
                if(empty(count($proforma_dds))){
                    $proforma_dds = 0;
                } else {
                    $proforma_dds = $proforma_dds[0];
                }
                $total = Proforma::select(DB::raw('count(proformas.no_proforma) as jumlah'))
                                    ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                                    ->leftjoin('dealers','awbs.kode_dealer','=','dealers.kode_dealer')
                                    ->where('depo',$depo)
                                    ->where('dds',$dds)
                                    ->whereMonth('awbs.tanggal_ds',$date)
                                    ->whereYear('awbs.tanggal_ds',$date)
                                    // ->whereNotNull('awbs.status') 
                                    //toggle status jangan lupa
                                    ->groupBy('dealers.depo')
                                    ->pluck('jumlah');
                if(empty(count($total))){
                    $total = 0;
                } else {
                    $total = $total[0];
                }               
                if ($total < 1){
                    $total =1;
                }
                $proforma_dds = round($proforma_dds/$total*100,1);
                return $proforma_dds;
            }

            $tambun = depo("TAMBUN","DDS 1",$date);
            // $tambun = round($tambun/$total*100,1);
            $tambun2 = depo("TAMBUN","DDS 2",$date);
            // $tambun2 = round($tambun2/$total*100,1);
            $bandung = depo("BANDUNG","DDS 2",$date);
            // $bandung = round($bandung/$total*100,1);
            $purwokerto = depo("PURWOKERTO","DDS 3",$date);
            // $purwokerto = round($purwokerto/$total*100,1);
            $semarang = depo("SEMARANG","DDS 3",$date);
            // $semarang = round($semarang/$total*100,1);
            $solo = depo("SOLO","DDS 3",$date);
            // $solo = round($solo/$total*100,1);
            $proforma_dds = [$tambun,$tambun2,$bandung,$purwokerto,$semarang,$solo];
            
            
            $proforma_tertunda = Proforma::select(DB::raw('DATE_FORMAT(awbs.tanggal_ds, "%d-%m-%Y") as name, count(proformas.no_awb) as y'))
                                    ->leftjoin('awbs','proformas.no_awb','awbs.no_awb')
                                    ->whereMonth('tanggal_ds',$date)
                                    ->whereNull('awbs.status')
                                    ->groupBy('tanggal_ds')
                                    ->get();
            if($total == 1){
                $total =0;
            }

            $data = compact('total','complete','notcomplete','ondelivery','proforma_tertunda');
            
            return view('dashboard.index',compact('data','proforma_dds'));
        // } else {
        //     return redirect('/home');
        // }
        
    }
    public function home(){
        return view('home.index'); 
    }
    public function import()
    {
        // $awb = Awb::All();
        // return view('home.import',compact('awb'));
        return view('home.import');
    }


    

}
