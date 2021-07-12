<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dealer;
use Illuminate\Pagination\Paginator;
use App\Depo;
use DB;

class DealerController extends Controller
{   
    public function index(){
        $dealer = Dealer::paginate(6);
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
        // if ($dds<>null){
        $rayon = Depo::where('dds',$dds)
                        ->where('depo',$depo)
                        ->groupBy('rayon')
                        ->pluck('rayon');
        // }
        // $rayon = ['a','b'];
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

    public function cari(Request $request){

        // $bulan = $request->bulan;
        // $tahun = $request->tahun;
        // $dds = $request->dds;
        // $status = $request->status; 
        // $search = $request->cari;
        
        $dealer = Dealer::when($request->keyword, function ($query) use ($request) {
            $query->select(DB::raw('dealers.alamat, dealers.kode_dealer, dealers.nama_dealer, dealers.dds, dealers.provinsi, dealers.kota, dealers.kodepos, dealers.depo, dealers.rayon'))
                            ->where('dealers.alamat','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.kode_dealer','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.nama_dealer','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.dds','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.provinsi','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.kota','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.kodepos','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.depo','LIKE','%'. $request->keyword . '%')
                            ->orWhere('dealers.rayon','LIKE','%'. $request->keyword . '%');
         })->paginate(6);    
        //ini apa    
        $dealer->appends($request->only('keyword'));            
    
    return view('dealer.index',compact('dealer')); 

    }
}
