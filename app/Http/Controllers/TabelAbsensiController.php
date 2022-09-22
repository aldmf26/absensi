<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Jenis;
use App\Models\Karyawan;
use App\Models\Pemakai;
use Illuminate\Http\Request;

class TabelAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tglDari = $request->tglDari;
            $tglSampai = $request->tglSampai;
            if (empty($dari)) {
                $dari = date('Y-m-1');
            } else {
                $dari = $tglDari;
            }
            if (empty($sampai)) {
                $sampai = date('Y-m-d');
            } else {
                $sampai = $tglSampai;
            }

            $data = [
                'title' => 'Absensi',
                'absensi' => Absensi::select('absensi.*', 'karyawan.nama_karyawan', 'karyawan.id_departemen', 'jenis_pekerjaan.jenis_pekerjaan', 'pemakai_jasa.pemakai')->join('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id_karyawan')->join('jenis_pekerjaan', 'absensi.id_jenis_pekerjaan', '=', 'jenis_pekerjaan.id')->join('pemakai_jasa', 'absensi.id_pemakai', '=', 'pemakai_jasa.id')->where('id_departemen', 'LIKE', '%' . '1' . '%')->whereBetween('absensi.tanggal', [$dari, $sampai])->orderBy('id', 'desc')->get(),
                'karyawan' => Karyawan::where('id_departemen', 'LIKE', '%' . '1' . '%')->get(),
                'pemakai' => Pemakai::all(),
                'jenis_pekerjaan' => Jenis::all(),
                'aktif' => 2,
                'id_departemen' => 1
            ];

            return view('tabelAbsensi', ['id_departemen' => 1], $data);
    }
}
