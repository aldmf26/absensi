<?php

namespace App\Http\Controllers;

use App\Models\Absensi_Resto;
use App\Models\Karyawan;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TabelRestoController extends Controller
{
    //
    public function index(Request $request)
    {
        $id_departemen = $request->id_departemen;
        $id_user = Auth::user()->id;
        // select('absensi_resto.*','karyawan.*')
        // ->join('karyawan','absensi_resto.id_karyawan', '=', 'karyawan.id_karyawan')->orderBy('id', 'desc'),
        if (empty($request->bulan)) {
            $bulan = date('m');
         } else {
             $bulan = $request->bulan;
         }
         if (empty($request->tahun)) {
            $tahun = date('Y');
         } else {
             $tahun = $request->tahun;
         }

        $data = [
            'title' => 'Absensi',
            'absensi' => Absensi_Resto::select('absensi_resto.*', 'karyawan.nama_karyawan', 'users.nama')->join('karyawan', 'absensi_resto.id_karyawan', '=', 'karyawan.id_karyawan')->join('users', 'absensi_resto.admin', '=', 'users.id')->where('absensi_resto.tanggal_masuk', 'LIKE', '%'.'2022-03-01'.'%')->orderBy('id', 'desc')->get(),
            'karyawan' => Karyawan::where('id_departemen', 'LIKE', '%'.'3'.'%')->get(),
            'status' => Status::all(),
            'tahun' => Absensi_Resto::all(),
            'bulan' => $bulan,
            'tahun_2' => $tahun,
            's_tahun' => DB::select(DB::raw("SELECT YEAR(a.tanggal_masuk) as tahun FROM absensi_resto as a group by YEAR(a.tanggal_masuk)")),
            'aktif' => 2,
            'id_departemen' => $id_departemen
        ];


        return view('tabelResto',['id_departemen' => 3], $data);
    }
}
