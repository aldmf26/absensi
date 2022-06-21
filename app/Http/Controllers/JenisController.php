<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JenisController extends Controller
{
    //
    public function index(Request $request)
    {
        // cek user ada menu apa aja
        $id_departemen = $request->id_departemen;
        $id_user = Auth::user()->id;
        $id_menu = DB::table('permisi')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 7)->first();
        if(empty($id_menu)) {
            // return redirect(route('login'));
            return back();
        } else {   
    	    $data = [
    		    'title' => 'Jenis Pekerjaan',
                'jenis' => Jenis::all(),
                'aktif' => 2,
                'id_departemen' => $id_departemen
    	    ];
    	return view('jenis.jenis', $data);
        }
    }

    public function addJenis(Request $request)
    {
        $data = [
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'keterangan' => $request->keterangan,
        ];

        Jenis::create($data);
        return redirect()->route('jenis', ['id_departemen' => 1]);
    }

    public function editJenis(Request $request)
    {
        $data = [
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'keterangan' => $request->keterangan,
        ];

        Jenis::where('id',$request->id_jenis_pekerjaan)->update($data);

      
        return redirect()->route('jenis', ['id_departemen' => 1]);
    }

    public function deleteJenis(Request $request)
    {
        Jenis::where('id',$request->id_jenis_pekerjaan)->delete();

        return redirect()->route('jenis', ['id_departemen' => 1]);
    }
}
