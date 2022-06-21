<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dotenv\Validator;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    //

    public function index()
    {
        if(Auth::check()) {
               $aksesMenu = 'home';
               return redirect(route($aksesMenu));

        } else {
            return view('login.login');
        }
        
    }

    public function register()
    {
        return view('login.register');
    }

    public function aksiLogin(Request $request)
    {

        $data = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        
        // $db = Login::where('username','=',$request->username)->get();

       if(Auth::attempt($data))
       {    
           $menu = [];
           $permisi = DB::table('permisi')->select('permisi.id_user')
                       ->join('menu', 'permisi.id_menu', '=', 'menu.id_menu')
                       ->join('users', 'permisi.id_user', '=', 'users.id')->where('id_user', 21)
                      
               ->get();
            // echo Auth::user()->id;
            $request->session()->put('nama', $data['username']);
            return redirect(route('home'))->with('sukses', 'Login Berhasil');
        } else {
            return back()->with('error', 'Username/Password salah');
       }

        
    }

    public function aksiReg(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'jenis' => $request->jenis,
            'password' => bcrypt($request->password)
        ];

        Login::create($data);
        return redirect()->route('users', ['id_departemen' => 1])->with('sukses', 'Berhasil Daftar');
    }

    public function aksiLogout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }

}
