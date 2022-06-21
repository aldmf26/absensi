<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Login;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mime\Header\ParameterizedHeader;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        // cek user ada menu apa aja
        $id_departemen = $request->id_departemen;
        $id_user = Auth::user()->id;
        $id_menu = DB::table('permisi')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 5)->first();
        if(empty($id_menu)) {
            // return redirect(route('login'));
            return back();
        } else {   
            $data = [
                'title' => 'User Management',
                'login' => Login::all(),
                'karyawan' => Karyawan::all(),
                'aktif' => 5,
                'id_departemen' => $id_departemen
            ];
            return view('users.users', $data);
        }
    }

    public function addUser(Request $request)
    {
        Users::where('id_user', $request->id_user)->delete();
        $id_menu = [];
        $id_users = [];
        foreach ($request->menu as $key => $d) {
            $data = [
                'id_user' => $request->id_user,
                'id_menu' => $d 
            ];
            // dd($request->all());
            Users::create($data);
        }     
        return redirect()->route('users',['id_departemen' => 1]);
    }

    public function editUser(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'jenis' => $request->jenis,
        ];
        Login::where('id', $request->id)->update($data);
        return redirect()->route('users',['id_departemen' => 1]);
    }

    public function deleteUser(Request $request)
    {
        Login::where('id',$request->id_user)->delete();

        return redirect()->route('users',['id_departemen' => 1]);
    }

}
