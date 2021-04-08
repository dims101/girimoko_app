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
        $credential = ['username'=>$username,'password'=>$password];

        $confirmation = User::where('username',$username)->first();
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
                    'data' => $confirmation
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
