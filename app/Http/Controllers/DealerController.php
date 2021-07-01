<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dealer;
use App\Depo;
use DB;

class DealerController extends Controller
{   
    public function index(){
        $dealer = Dealer::all();
        return view('dealer.index',compact('dealer'));
    }

    public function tambah(){
        $dds = Dealer::select(DB::raw('dds'))
                ->distinct()
                ->get();
        $depo = Dealer::select(DB::raw('depo'))
                ->distinct()
                ->get();
        $rayon = Dealer::select(DB::raw('rayon'))
                ->distinct()
                ->get();
                // ->unique('dds');
        // return $dds;die;
        return view('dealer.tambah',compact('dds','depo','rayon'));
    }

    public function store(Request $request){
        Dealer::create([
            'kode_dealer'=> $request->kode_dealer,
            'nama_dealer'=> $request->nama_dealer,
            'alamat'=> $request->alamat,
            'provinsi'=> $request->provinsi,
            'kota'=> $request->kota,
            'kodepos'=> $request->kodepos,
            'dds'=> $request->dds,
            'depo'=> $request->depo,
            'rayon'=> $request->rayon,
            'target'=> '1'
        ]);
        return redirect('/dealer');
    }

    public function edit(Dealer $dealer)
    {
        $dds = Dealer::select(DB::raw('dds'))
                ->distinct()
                ->get();
        $depo = Dealer::select(DB::raw('depo'))
                ->distinct()
                ->get();
        $rayon = Dealer::select(DB::raw('rayon'))
                ->distinct()
                ->get();
        $dealer = Dealer::where('id',$dealer->id)->first();
        
        return view('dealer.edit',['dealer'=>$dealer], compact('dealer','dds','depo','rayon'));
        
    }

    public function selected(Request $request){
        $dds = $request->dds;
        $depo = Depo::where('dds',$dds)
                        ->groupBy('depo')
                        ->pluck('depo');
        return response()->json($depo);
    }
    public function rayon(Request $request){
        $depo = $request->depo;
        $dds = $request->dds;
        if ($dds<>null){
        $rayon = Depo::where('dds',$dds)
                        ->where('depo',$depo)
                        ->groupBy('rayon')
                        ->pluck('rayon');
        }
        $rayon = ['a','b'];
        return response()->json($rayon);
    }

    public function update(Request $request, Dealer $dealer)
    {
        Dealer::where('id', $dealer->id)
                ->update([
                    'kode_dealer'=> $request->kode_dealer,
                    'nama_dealer'=> $request->nama_dealer,
                    'alamat'=> $request->alamat,
                    'provinsi'=> $request->provinsi,
                    'kota'=> $request->kota,
                    'kodepos'=> $request->kodepos,
                    'dds'=> $request->dds,
                    'depo'=> $request->depo,
                    'rayon'=> $request->rayon,
                    'target'=> '1'
                ]);
        return redirect('/dealer');
    }

    public function destroy(Dealer $dealer)
    {
        Dealer::destroy($dealer->id);
        return redirect('/dealer');
    }
}
