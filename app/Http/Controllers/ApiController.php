<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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
        $app_key = $request->app_key;
        $credential = ['username'=>$username,'password'=>$password];
        if($app_key != config('app.key')){
            $response = array(
                'success' => '0',
                'message' => 'Akses ditolak!'

                );
            return response()->json($response);
        } else {        
            $confirmation = User::where('username',$username)->where('level',"driver")->orwhere('level','Super Admin')->first();
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
}
