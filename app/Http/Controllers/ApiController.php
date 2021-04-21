<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Awb;
use App\Proforma;
use App\Dealer;
use App\Pengiriman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Hash;

class ApiController extends Controller
{
    public function coba(Request $request){
        return response()->json(User::all());
        
    }
    
    protected function guard()
    {
        return Auth::guard();
    }

    public function login(Request $request){
        $username = $request->username;
        $password = $request->password;
        $app_secret = $request->app_secret;
        $credential = ['username'=>$username,'password'=>$password];

        if($app_secret != config('app.secret')){
            $response = array(
                'success' => '0',
                'message' => 'Akses ditolak!'

                );
            return response()->json($response);
        } else {        
            $confirmation = User::where('username',$username)->wherein('level',array('driver','Super Admin'))->first();
            if(!$confirmation){
                $response = array(
                    'success' => '0',
                    'message' => 'Username tidak terdaftar!'

                    );
                return response()->json($response);
            } else if($confirmation->id != 0 ){
                if(Auth::guard()->attempt($credential,$request->filled('remember'))){
                    $response = array(
                        'success' => '1',
                        'message' => 'Login berhasil!',
                        'username' => $confirmation->username,
                        'name' => $confirmation->name,
                        'telepon' => $confirmation->telepon,
                        'level' => $confirmation->level,
                        'active' => $confirmation->active,
                        //'data' => $confirmation
                    );
                    return response()->json($response);
                }    
            }
            //return response()->json($confirmation, 200);
            //$cek = $confirmation;
            $response = array(
                'success' => '0',
                'message' => 'Password anda salah!'
                );
            return response()->json($response);
        }

    }
    public function getAwb(Request $request){
        $app_secret = $request->app_secret;
        $no_awb = $request->no_awb;

        if($app_secret != config('app.secret')){
            $response = array(
                'success' => '0',
                'message' => 'Akses ditolak!'

                );
            return response()->json($response);
        } else {
            $data_awb = Awb::where('no_awb', $no_awb)->first();
            if(empty($data_awb)){
                $response = array(
                    'success' => '0',
                    'message' => 'AWB tidak ditemukan!'
                );
                return response()->json($response);
            }else if($data_awb->status == "1"){
                $response = array(
                    'success' => '2',
                    'message' => 'AWB telah sampai tujuan.'
                );
                return response()->json($response);
            } else {
                $kode_dealer = $data_awb->kode_dealer;
                $dealer = Dealer::where('kode_dealer',$kode_dealer)->first();
                // $nama_dealer = $dealer['nama_dealer'];
                $nama_dealer = $dealer->nama_dealer;
                
                $jml_koli = Proforma::get()->where('no_awb',$no_awb)->sum('koli');
                $jml_proforma = Proforma::get()->where('no_awb',$no_awb)->count();

                $response = array(
                    'success' => '1',
                    'message' => 'AWB berhasil ditemukan',
                    'kode_dealer' => $kode_dealer,
                    'nama_dealer' => $nama_dealer,
                    'jml_koli' => $jml_koli,
                    'jml_proforma' => $jml_proforma,
                );
                return response()->json($response);
            }
        }

    }
    public function getProforma(Request $request){
        $app_secret = $request->app_secret;
        $no_awb = $request->no_awb;

        if($app_secret != config('app.secret')){
            $response = array(
                'success' => '0',
                'message' => 'Akses ditolak!'

                );
            return response()->json($response);
        } else {
            $proforma = Proforma::select('no_proforma','koli','no_awb','tipe')->where('no_awb',$no_awb)->get();
            // dd($proforma);
            $response = array(
                'success' => '1',
                'message' => 'Success',
                'data' => $proforma
            );
            return response()->json($response);
        }
    }
    public function getDealer(Request $request){
        $app_secret = $request->app_secret;

        if($app_secret != config('app.secret')){
            $response = array(
                'success' => '0',
                'message' => 'Akses ditolak!'

                );
            return response()->json($response);
        } else {
            if(empty($request->filter)){
                $dealer = Dealer::select('kode_dealer','nama_dealer','alamat')->get();
                $response = array(
                    'success' => '1',
                    'message' => 'Success',
                    'data' => $dealer
                );
                return response()->json($response);

            } else {
                $filter = $request->filter;
                $dealer = Dealer::select('kode_dealer','nama_dealer','alamat')
                                    ->orWhere('kode_dealer', 'LIKE','%' .$filter. '%')
                                    ->orWhere('nama_dealer', 'LIKE','%' .$filter. '%')
                                    ->orWhere('alamat', 'LIKE','%' .$filter. '%')->get();
                $response = array(
                    'success' => '1',
                    'message' => 'Success',
                    'data' => $dealer
                );
                return response()->json($response);
            }

        }
    }
    public function storeAwb(Request $request){
        $username = $request->username;
        $no_awb = $request->no_awb;  
        $no_kendaraan = $request->no_kendaraan;
        $penerima =$request->penerima;
        $keterangan = $request->keterangan;
        $app_secret = $request->app_secret;
        // dd($app_secret);
        if($app_secret != config('app.secret')){
            $response = array(
                'success' => '0',
                'message' => 'Akses ditolak!'

                );
            return response()->json($response);
        } else {
            $dealer = Awb::where('no_awb',$no_awb)
                            ->first();
            $target = Dealer::select('target')
                            ->where('kode_dealer',$dealer->kode_dealer)
                            ->first();
            
            // dd($dealer);
            //tinggal cek tanggal besok sabtu apa minggu(belum dibuat)
            $today = Carbon::now()->setTimezone('Asia/Jakarta');
            $tanggal_terima = $today->toDateString();
            $waktu_terima = $today->toTimeString();

            if($request->hasFile('foto')){
                $file = $request->file('foto');
                // $file_name = $file->getClientOriginalName();
                $file_extension = $file->getClientOriginalExtension();
                $file_name = $no_awb .'-'.$tanggal_terima . '.' . $file_extension;
                $file_path = $file->getRealPath();
                $file_size = $file->getSize();     
                $file->move(public_path('bukti_awb/'),$file_name);       
            }

            $pengiriman = Pengiriman::create([
                'username'=>$username,
                'tanggal_terima'=>$tanggal_terima,
                'waktu_terima'=>$waktu_terima,
                'penerima'=>$penerima,
                'foto_awb'=> $file_name,
                'no_kendaraan'=>$no_kendaraan,
                'target_aktual'=>'1',
            ]);
            //validasi apakah sudah ada pengiriman sebelumnya(belum dibuat)
            $awb = Awb::where('no_awb',$no_awb)
                        ->update([
                            'id_pengiriman'=>$pengiriman->id,
                            'keterangan'=>$keterangan,
                            'status'=>'1'
                        ]);
            
            return response()->json('berhasil');
        }
    }
    public function storeImage(Request $request){
        return response()->json($request->foto);
    }
}
