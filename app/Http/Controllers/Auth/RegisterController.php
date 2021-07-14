<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showRegistrationForm()
    {
        $logged  = auth()->user()->level;
        if($logged == "Super Admin"){
            $users = User::all();
        } else {
            $users = User::where('level','driver')
                            ->get();
        }
        return view('auth.register',compact('users'));
    }
    
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath())->with('message','Pengguna baru berhasil ditambahkan!');
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::REGISTER;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {   
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'level' => $data['level'],
            'telepon' => $data['telepon'],
            'password' => Hash::make($data['password']),
            //'remember_token' => Str::random(60),
        ]);
    }

    public function edit(User $user)
    {
    
        $user = User::where('id',$user->id)->first();
        
        return view('auth.edit_user',['user'=>$user], compact('user'));
        
    }

    public function update(Request $request, User $user)
    {
        User::where('id', $user->id)
                ->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'level' => $request->level,
                    'telepon' => $request->telepon,
                    'password' => Hash::make($request->password)
                ]);
        return redirect('/register');
    }

    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('/register');
    }

    
}
