<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Awb;
use App\Dealer;
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
        // $summary = Dealer::All();
        // //     // dd(count($proyek));                       
        $sum = Awb::All();
        return view('summary.index', compact('sum'));
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
        return view('summary.detail',compact('detail'));
    }
}
