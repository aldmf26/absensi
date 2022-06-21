<?php

namespace App\Http\Controllers;

use App\Models\Pemakai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemakaiController extends Controller
{
    //
    public function index(Request $request)
    {
        // cek user ada menu apa aja
        $id_departemen = $request->id_departemen;
        $id_user = Auth::user()->id;
        $id_menu = DB::table('permisi')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 8)->first();
        if(empty($id_menu)) {
            // return redirect(route('login'));
            return back();
        } else {   

            $data = [
                'title' => 'Pemakai',
                'pemakai_jasa' => Pemakai::all(),
                'aktif' => 2,
                'id_departemen' => $id_departemen
            ];
            return view('pemakai.pemakai', $data);
        }
    }

    public function addPemakai(Request $request)
    {
        $data = [
            'pemakai' => $request->pemakai,
            'keterangan' => $request->keterangan,
        ];

        Pemakai::create($data);
        return redirect()->route('pemakai', ['id_departemen' => 1]);
    }

    public function editPemakai(Request $request)
    {
        $data = [
            'pemakai' => $request->pemakai,
            'keterangan' => $request->keterangan,
        ];

        Pemakai::where('id_pemakai',$request->id)->update($data);

      
        return redirect()->route('pemakai', ['id_departemen' => 1]);
    }

    public function deletePemakai(Request $request)
    {
        Pemakai::where('id_pemakai',$request->id)->delete();

        return redirect()->route('pemakai', ['id_departemen' => 1]);
    }
}
