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
use Intervention\Image\ImageManagerStatic as Image;
use Hash;
use DB;
use DateTime;
use DatePeriod;
use DateInterval;

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
            }else if($data_awb->status <> null){
                $response = array(
                    'success' => '2',
                    'message' => 'AWB telah sampai tujuan.'
                );
                return response()->json($response);
            } else {
                $kode_dealer = $data_awb->kode_dealer;
                $dealer = Dealer::where('kode_dealer',$kode_dealer)->first();
                $target = Dealer::select('target')
                            ->where('kode_dealer',$dealer->kode_dealer)
                            ->first();
                $target = $target->target;
                $tanggal_start = Awb::where('no_awb',$no_awb)
                                    ->first();
                $tanggal_start = $tanggal_start->tanggal_ds;
                // $nama_dealer = $dealer['nama_dealer'];
                $nama_dealer = $dealer->nama_dealer;
                
                $jml_koli = Proforma::get()->where('no_awb',$no_awb)->sum('koli');
                $jml_proforma = Proforma::get()->where('no_awb',$no_awb)->count();
                //delay here
                $today = Carbon::now()->setTimezone('Asia/Jakarta');
                $tanggal_terima = $today->toDateString();
                $begin = new DateTime($tanggal_start);
                $end = new DateTime($tanggal_terima);
    
                $daterange     = new DatePeriod($begin, new DateInterval('P1D'), $end);
                //mendapatkan range antara dua tanggal dan di looping
                $i=0;
                $x     =    0;
                $end     =    1;
    
                foreach($daterange as $date){
                    $daterange     = $date->format("Y-m-d");
                    $datetime     = DateTime::createFromFormat('Y-m-d', $daterange);
    
                    //Convert tanggal untuk mendapatkan nama hari
                    $day         = $datetime->format('D');
    
                    //Check untuk menghitung yang bukan hari sabtu dan minggu
                    if($day!="Sun") {
                        //echo $i;
                        $x    +=    $end-$i;
                        
                    }
                    $end++;
                    $i++;
                }  
                $status = $x-$target;
                if($status == -1 or $status == 0){
                    $status = "Ontime";
                }
                if ($status >3){
                    $status = "Delay >3 hari";
                }
                if($status == 1){
                    $status = "Delay 1 hari";
                }
                if($status == 2){
                    $status = "Delay 2 hari";
                }
                if($status == 3){
                    $status = "Delay 3 hari";
                }

                $response = array(
                    'success' => '1',
                    'message' => 'AWB berhasil ditemukan',
                    'kode_dealer' => $kode_dealer,
                    'nama_dealer' => $nama_dealer,
                    'jml_koli' => $jml_koli,
                    'status' => $status,
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
            $proforma = Proforma::select('no_proforma','koli','no_awb','tipe','total_koli','status','keterangan')
                                    ->where('no_awb',$no_awb)->get();
            // dd($proforma);
            $response = array(
                'success' => '1',
                'message' => 'Success',
                'data' => $proforma
            );
            return response()->json($response);
        }
    }

    public function storeProforma(Request $request){
        $app_secret = $request->app_secret;

        if($app_secret != config('app.secret')){
            $response = array(
                'success' => '0',
                'message' => 'Akses ditolak!'

                );
            return response()->json($response);
        } else {
            $no_proforma = $request->no_proforma;
            $no_awb = $request->no_awb;
            $status = $request->status;
            $keterangan = $request->keterangan;
            Proforma::where('no_proforma',$no_proforma)
                        ->where('no_awb',$no_awb)
                            ->update([
                                    'status'=>$status,
                                    'keterangan'=>$keterangan,
                            ]);            
            $response = array(
                'success' => '1',
                'message' => 'Proforma berhasil disimpan!'

                );
            return response()->json($response);
        }
    }
    public function storeAllProforma(Request $request){
        $app_secret = $request->app_secret;

        if($app_secret != config('app.secret')){
            $response = array(
                'success' => '0',
                'message' => 'Akses ditolak!'

                );
            return response()->json($response);
        } else {
            $no_awb =$request->no_awb;
            $status = $request->status;
            $keterangan = $request->keterangan;       
            $done = Proforma::select(DB::raw('(sum(koli) - sum(total_koli)) as hasil'))
                                ->where('no_awb',$no_awb)
                                ->whereNull('status')
                                ->first();  
            // return $done->hasil;die;         
            if ($done->hasil == 0){
                
            Proforma::where('no_awb',$no_awb)
                    ->whereNull('status')
                    ->update([
                        'status'=>$status,
                        'keterangan'=>$keterangan
                    ]);
            $response = array(
                'success' => '1',
                'message' => 'Proforma berhasil disimpan!'

                );
            return response()->json($response);
            } else {
            $response = array(
                'success' => '0',
                'message' => 'Ada proforma yang tidak lengkap!'

                );
            return response()->json($response);
            }
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
        $app_secret = $request->app_secret;

        if($app_secret != config('app.secret')){
            $response = array(
                'success' => '0',
                'message' => 'Akses ditolak!'

                );
            return response()->json($response);
        } else {
            $username = $request->username;
            $no_awb = $request->no_awb;  
            // $no_kendaraan = $request->no_kendaraan; katanya diilangin
            $penerima =$request->penerima;
            $keterangan = $request->keterangan;

            $cek = Proforma::where('no_awb',$no_awb)
                            ->whereNull('status')
                            ->pluck('no_proforma')
                            ->toArray();
            // return $cek;die;

            if (!empty($cek)){
                $list = implode(', ', $cek);
                $response = array(
                    'success' => '0',
                    'message' => 'No proforma '.$list.' belum dicek!'
    
                    );
                return response()->json($response);die;
            } else {
                $daftar = Proforma::where('no_awb',$no_awb)
                                ->pluck('no_proforma');
                // return $daftar;die;
                
                foreach ($daftar as $d){
                    
                    $statusP = Proforma::where('no_proforma',$d)
                                ->where('no_awb',$no_awb)
                                ->first();
                    $statusP = $statusP->status;
                    if($statusP == 3){
                        $statusP = 1;
                    } else if($statusP == 4){
                        $statusP = 2;
                    }
                    Proforma::where('no_proforma',$d)
                                ->where('no_awb',$no_awb)
                                ->update([
                                   'status'=>$statusP, 
                                ]);
                }

            }

            $dealer = Awb::where('no_awb',$no_awb)
                            ->first();
            $target = Dealer::select('target')
                            ->where('kode_dealer',$dealer->kode_dealer)
                            ->first();
                             $target = $target->target;
            //atas lead time
            $tanggal_ds = $dealer->tanggal_ds;
            // return $tanggal_ds;die;
            //tinggal cek tanggal besok sabtu apa minggu(belum dibuat)(sudah)
            $today = Carbon::now()->setTimezone('Asia/Jakarta');
            $tanggal_terima = $today->toDateString();
            $waktu_terima = $today->toTimeString();
            // return $tanggal_terima;die;
            $begin = new DateTime($tanggal_ds);
            $end = new DateTime($tanggal_terima);

            $daterange     = new DatePeriod($begin, new DateInterval('P1D'), $end);
            //mendapatkan range antara dua tanggal dan di looping
            $i=0;
            $x     =    0;
            $end     =    1;

            foreach($daterange as $date){
                $daterange     = $date->format("Y-m-d");
                $datetime     = DateTime::createFromFormat('Y-m-d', $daterange);

                //Convert tanggal untuk mendapatkan nama hari
                $day         = $datetime->format('D');

                //Check untuk menghitung yang bukan hari sabtu dan minggu
                if($day!="Sun") {
                    //echo $i;
                    $x    +=    $end-$i;
                    
                }
                $end++;
                $i++;
            }  
            $status = $x-$target;
            if($status < 0){
                $status = 0;
            }
            if ($status >3){
                $status = 4;
            }

            // $file = str_replace('data:image/jpeg;base64,', '', $request->foto);
            // $file = str_replace(' ', '+', $file);
            // $file = base64_decode($file);
            $file = Image::make($request->foto)->stream('jpg',100);
            $file_name = $no_awb .'-'.$tanggal_terima . '.jpg';
            file_put_contents(public_path('bukti_awb/'.$file_name), $file);

            $no_kendaraan = Awb::where('no_awb',$no_awb)
                                ->select('no_kendaraan')
                                ->first();
            $pengiriman = Pengiriman::create([
                'username'=>$username,
                'tanggal_terima'=>$tanggal_terima,
                'waktu_terima'=>$waktu_terima,
                'penerima'=>$penerima,
                'foto_awb'=> $file_name,
                'no_kendaraan'=>$no_kendaraan->no_kendaraan,
                'target_aktual'=> $status,
            ]);

            $awb = Awb::where('no_awb',$no_awb)
                        ->update([
                            'id_pengiriman'=>$pengiriman->id,
                            'keterangan'=>$keterangan,
                            'status'=>$status
                            //toggle status
            ]);
            //validasi apakah sudah ada pengiriman sebelumnya(belum dibuat)
           
            if(!empty($proformas)){
                foreach($proformas as $proforma){
                    Proforma::where('no_proforma',$proforma[0])
                            ->update([
                                    'status'=>$proforma[1],
                                    'keterangan'=>$proforma[2],
                            ]);
                }
            }
            $response = array(
                'success' => '1',
                'message' => 'Berhasil!'

                );
            return response()->json($response);
        }
    }

    public function getFinalAwb(Request $request){
        $app_secret = $request->app_secret;

        if($app_secret != config('app.secret')){
            $response = array(
                'success' => '0',
                'message' => 'Akses ditolak!'

                );
            return response()->json($response);
        } else {
            if(empty($request->filter)){
                 $awbs = Awb::select(DB::raw('
                                awbs.no_awb as kode_awb,
                                awbs.kode_dealer,
                                date_format(awbs.tanggal_ds, "%d-%m-%Y") as tgl_kirim,
                                awbs.status as status_pengiriman,
                                date_format(pengirimans.tanggal_terima, "%d-%m-%Y") as tgl_terima,
                                pengirimans.username as supir
                            '))
                            ->leftjoin('pengirimans','awbs.id_pengiriman','pengirimans.id')
                            ->where('awbs.status','!=',null)
                            ->get();
            
            } else {
                $filter = $request->filter;
                $awbs = Awb::select(DB::raw('
                                awbs.no_awb as kode_awb,
                                awbs.kode_dealer,
                                awbs.tanggal_ds as tgl_kirim,
                                pengirimans.tanggal_terima as tgl_terima,
                                pengirimans.username as supir
                            '))
                            ->leftjoin('pengirimans','awbs.id_pengiriman','pengirimans.id')
                            ->where('awbs.status','!=',null)
                            ->where('no_awb','LIKE','%'.$filter.'%')
                            ->Orwhere('kode_dealer','LIKE','%'.$filter.'%')
                            ->Orwhere('tanggal_ds','LIKE','%'.$filter.'%')
                            ->Orwhere('tanggal_terima','LIKE','%'.$filter.'%')
                            ->Orwhere('username','LIKE','%'.$filter.'%')
                            ->get();
            }
            $response = array(
                'success' => '1',
                'message' => 'Success',
                'data'     => $awbs
                );
            return response()->json($response);
        }
    }
    
}
