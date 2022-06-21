<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        // cek user ada menu apa aja
        $id_user = Auth::user()->id;
        $id_menu = DB::table('permisi')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 12)->first();
        if(empty($id_menu)) {
            // return redirect(route('login'));
            return back();
        } else {   

            $data = [
                'title' => 'Shift',
                'shift' => Status::all(),
                'aktif' => 2,
                'id_departemen' => 4
            ];
            return view('shift.shift', $data);
        }
    }

    public function addShift(Request $request)
    {
        $data = [
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ];

        Status::create($data);
        return redirect()->route('shift', ['id_departemen' => 4])->with('sukses', 'Berhasil tambah shift');
    }

    public function editShift(Request $request)
    {
        $data = [
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ];

        Status::where('id_status',$request->id)->update($data);

      
        return redirect()->route('shift', ['id_departemen' => 4])->with('sukses', 'Berhasil edit shift');
    }

    public function deleteShift(Request $request)
    {
        Status::where('id_status',$request->id)->delete();

        return redirect()->route('shift', ['id_departemen' => 4])->with('error', 'Berhasil hapus shift');
    }
}
