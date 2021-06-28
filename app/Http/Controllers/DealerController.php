<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dealer;

class DealerController extends Controller
{   
    public function index(){
        $dealer = Dealer::all();
        return view('dealer.index',compact('dealer'));
    }

    public function tambah(){
        return view('dealer.tambah');
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
        $dealer = Dealer::where('id',$dealer->id)->first();
        
        return view('dealer.edit',['dealer'=>$dealer], compact('dealer'));
        
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
