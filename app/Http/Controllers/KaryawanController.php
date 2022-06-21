<?php

namespace App\Http\Controllers;

use App\Exports\KaryawanAgrilarasExport as ExportsKaryawanAgrilarasExport;
use App\Exports\KaryawanExport;
use App\KaryawanAgrilarasExport;
use App\Imports\KaryawanImport;
use App\Models\Gaji;
use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class KaryawanController extends Controller
{
    //
    public function index(Request $request)
    {
        // cek user ada menu apa aja
        $id_departemen = $request->id_departemen;
        $id_user = Auth::user()->id;
        $id_menu = DB::table('permisi')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 4)->first();
        if (empty($id_menu)) {
            // return redirect(route('login'));
            return back();
        } else {

            $data = [
                'title' => 'Karyawan',
                'karyawan' => Karyawan::select('departemen.*', 'karyawan.*')->join('departemen', 'karyawan.id_departemen', '=', 'departemen.id_departemen')->where('departemen.id_departemen', 'LIKE', '%' . '1' . '%')->orderBy('id_karyawan', 'desc')->get(),
                'departemen' => Departemen::where('id_departemen', $id_departemen)->get(),
                'aktif' => 1,
                'id_departemen' => $id_departemen
            ];
            return view('karyawan.karyawan', $data);
        }
    }

    public function karyawanAgrilaras(Request $request)
    {
        $id_departemen = $request->id_departemen;
        $data = [
            'title' => 'Karyawan',
            'karyawan' => Karyawan::join('departemen', 'karyawan.id_departemen', '=', 'departemen.id_departemen')->where('departemen.id_departemen', 'LIKE', '%' . '4' . '%')->orderBy('id_karyawan', 'desc')->get(),
            'departemen' => Departemen::where('id_departemen', $id_departemen)->get(),
            'aktif' => 1,
            'id_departemen' => 4,
            'shift' => Status::all(),
        ];
        return view('karyawanAgrilaras.karyawan', $data);
    }

    public function addKaryawan(Request $request)
    {
        $id_departemen = $request->id_departemen;
        $data = [
            'nama_karyawan' => $request->nama_karyawan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'id_departemen' => $request->id_departemen,
            'posisi' => $request->posisi
        ];
        if ($id_departemen == 1) {
            $rot = 'karyawan';
        }
        if ($id_departemen == 4) {
            $rot = 'karyawanAgrilaras';
        }

        $kr = Karyawan::create($data);
        $data2 = [
            'id_karyawan' => $kr->id,
            'rp_m' => $request->rp_m,
            'rp_e' => $request->rp_e,
            'rp_sp' => $request->rp_sp,
            'g_bulanan' => $request->g_bulanan,
        ];
        Gaji::create($data2);

        return redirect()->route($rot, ['id_departemen' => $id_departemen])->with('sukses', 'Berhasil Tambah Data Karyawan');
    }

    public function editKaryawan(Request $request)
    {
        $data = [
            'nama_karyawan' => $request->nama_karyawan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'posisi' => $request->posisi
        ];

        Karyawan::where('id_karyawan', $request->id_karyawan)->update($data);

        $cek = Gaji::where('id_karyawan', $request->id_karyawan)->first();
        if($cek) {
            $data2 = [
                'rp_m' => $request->rp_m,
                'rp_e' => $request->rp_e,
                'rp_sp' => $request->rp_sp,
                'g_bulanan' => $request->g_bulanan,
            ];
            Gaji::where('id_karyawan', $request->id_karyawan)->update($data2);
        } else {
            $data3 = [
                'id_karyawan' => $request->id_karyawan,
                'rp_m' => $request->rp_m,
                'rp_e' => $request->rp_e,
                'rp_sp' => $request->rp_sp,
                'g_bulanan' => $request->g_bulanan,
            ];
            Gaji::create($data3);
        }

        $id_departemen = $request->id_departemen;

        if ($id_departemen == 1) {
            $rot = 'karyawan';
        }
        if ($id_departemen == 4) {
            $rot = 'karyawanAgrilaras';
        }

        return redirect()->route($rot, ['id_departemen' => $id_departemen])->with('sukses', 'Berhasil Ubah Data Karyawan');
    }

    public function deleteKaryawan(Request $request)
    {
        Karyawan::where('id_karyawan', $request->id_karyawan)->delete();
        Gaji::where('id_karyawan', $request->id_karyawan)->delete();
        $id_departemen = $request->id_departemen;

        if ($id_departemen == 1) {
            $rot = 'karyawan';
        }
        if ($id_departemen == 4) {
            $rot = 'karyawanAgrilaras';
        }

        return redirect()->route($rot, ['id_departemen' => $id_departemen])->with('error', 'Data berhasil Dihapus');
    }

    public function excelKaryawan(Request $request)
    {

        return Excel::download(new KaryawanExport, 'karyawan.xlsx');
    }

    public function excelKaryawanAgrilaras()
    {
        return Excel::download(new ExportsKaryawanAgrilarasExport, 'karyawan.xlsx');
    }

    public function importKaryawan(Request $request)
    {
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();

        if ($ext == 'xls') {
            $render = new Xls();
        } else {
            $render = new Xlsx();
        }

        $data = $render->load($file);
        $d = $data->getActiveSheet()->toArray();

        foreach ($d as $x => $excel) {

            $datas = [
                'nama_karyawan' => $excel['1'],
                'tanggal_masuk' => date("Y-m-d", strtotime($excel['2'])),
                'id_departemen' => $excel['3'],
                'posisi' => $excel['4']
            ];
            Karyawan::create($datas);
        }
        $id_departemen = $request->id_departemen;
        if ($id_departemen == 1) {
            $rot = 'karyawan';
        }
        if ($id_departemen == 4) {
            $rot = 'karyawanAgrilaras';
        }

        return redirect()->route($rot, ['id_departemen' => $id_departemen])->with('sukses', 'Data berhasil Diimport');
    }
}
