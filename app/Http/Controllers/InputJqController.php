<?php

namespace App\Http\Controllers;

use App\Models\Input;
use Illuminate\Http\Request;

class InputJqController extends Controller
{
    //
    public function index(Request $request){
        $data = [
            'input' => Input::all(),
            'id_departemen' => 1
        ];
        return view('welcome',$data);
    }

    public function simpan(Request $request) {
        $nama = $request->nama;
        $pekerjaan = $request->pekerjaan;
     
        for($i = 0; $i < count($nama); $i++)
        {
            $data = [
                'nama' => $nama[$i],
                'pekerjaan' => $pekerjaan[$i]
            ];
    
            Input::create($data);
        }
        return redirect(route('input'));
    }
}
