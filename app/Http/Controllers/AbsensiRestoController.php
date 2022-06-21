<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Absensi_Resto;
use App\Models\Jenis;
use App\Models\Karyawan;
use App\Models\Pemakai;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsensiRestoController extends Controller
{
    //
    public function index(Request $request)
    {
        // cek user ada menu apa aja
        $id_departemen = $request->id_departemen;
        $id_user = Auth::user()->id;
        $id_menu = DB::table('permisi')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 3)->first();
       
       if(empty($id_menu)){
            // return redirect(route('login'));
            return view('login.login');
       } else {
           $data = [
               'title' => 'Absensi',
               'absensi' => Absensi_Resto::select('absensi_resto.*','karyawan.*')->join('karyawan','absensi_resto.id_karyawan', '=', 'karyawan.id_karyawan')->join('departemen', 'karyawan.id_departemen', '=', 'departemen.id_departemen')->where('id_departemen', 'LIKE', '%'.'3'.'%')->orderBy('id', 'desc'),
               'karyawan' => Karyawan::where('id_departemen', 'LIKE', '%'.'3'.'%')->get(),
               'status' => Status::all(),
               'aktif' => 2,
               'id_departemen' => $id_departemen
           ];

           return view('absensi_resto.absensi_resto',$data);
       }
 	
    }

    public function detail_resto(Request $request)
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
            'absensi' => Absensi_Resto::select('absensi_resto.*', 'karyawan.nama_karyawan', 'users.nama')->join('karyawan', 'absensi_resto.id_karyawan', '=', 'karyawan.id_karyawan')->join('users', 'absensi_resto.admin', '=', 'users.id')->orderBy('id', 'desc')->get(),
            'karyawan' => Karyawan::where('id_departemen', 'LIKE', '%'.'3'.'%')->get(),
            'status' => Status::all(),
            'bulan' => $bulan,
            'tahun_2' => $tahun,
            's_tahun' => DB::select(DB::raw("SELECT YEAR(a.tanggal_masuk) as tahun FROM absensi_resto as a group by YEAR(a.tanggal_masuk)")),
            'aktif' => 2,
            'id_departemen' => $id_departemen
        ];

        return view('absensi_resto.absensi_resto_detail', ['id_departemen' => 3],$data);
    }

    public function add_resto(Request $request)
    {
        

        $data = [
            'id_karyawan' => $request->id_karyawan,
            'status' => $request->status,
            'tanggal_masuk' => $request->tanggal_masuk,
            'admin' => Auth::user()->id,
            'id_departemen' => $request->departemen
        ];
        $cek = Absensi_Resto::where('tanggal_masuk',$request->tanggal_masuk)->where('id_karyawan', $request->id_karyawan)->first();

        if($cek){
            return redirect()->route('add_edit_resto', ['id_departemen' => 3])->with('error', 'Karyawan Sudah Absen');
        } else {
            Absensi_resto::create($data);
            return redirect()->route('add_edit_resto', ['id_departemen' => 3])->with('sukses', 'Berhasil Tambah Data Absen resto');
        }
        
    }

    public function edit_resto(Request $request)
    {
        $data = [
            'id_karyawan' => $request->id_karyawan,
            'status' => $request->status,
            'tanggal_masuk' => $request->tanggal_masuk,
            'admin' => Auth::user()->id,

        ];

        Absensi_resto::where('id',$request->id_absen)->update($data);

      
        return redirect()->route('add_edit_resto', ['id_departemen' => 3])->with('sukses', 'Berhasil Ubah Data Absen resto');
    }

    public function add_edit_resto(Request $request)
    {
        $id_departemen = $request->id_departemen;
        $id_user = Auth::user()->id;
        // select('absensi_resto.*','karyawan.*')
        // ->join('karyawan','absensi_resto.id_karyawan', '=', 'karyawan.id_karyawan')->orderBy('id', 'desc'),
        $data = [
            'title' => 'Absensi',
            'absensi' => Absensi_resto::select('absensi_resto.*', 'karyawan.nama_karyawan', 'users.nama')->join('karyawan', 'absensi_resto.id_karyawan', '=', 'karyawan.id_karyawan')->join('users', 'absensi_resto.admin', '=', 'users.id')->orderBy('id', 'desc')->get(),
            'karyawan' => Karyawan::where('id_departemen', 'LIKE', '%'.'3'.'%')->get(),
            'status' => Status::all(),
            'aktif' => 2,
            'id_departemen' => $id_departemen
        ];
        return view('absensi_resto.absensi_resto_edit',$data);
    }

    public function input_resto(Request $request)
    {
       $data = [
        'id_karyawan' => $request->id_karyawan,
        'status' => $request->status,
        'tanggal_masuk' => $request->tanggal,
        'admin' => Auth::user()->id,
        // 'admin' => $request->admin,
       ];
       

       Absensi_resto::create($data);
       return redirect()->route('absensi_resto', ['id_departemen' => 3,'bulan' => $request->bulan, 'tahun' => $request->tahun]);

    }

    public function update_resto(Request $request)
    {
        $data = [
            'status' => $request->status,
        ];

        Absensi_Resto::where('id',$request->id_absen)->update($data);
        return true;
    }

    public function delete_resto(Request $request)
    {
        Absensi_resto::where('id',$request->id_absen)->delete();
        return true;
    }

    public function tabelResto(Request $request)
    {
        view ('tabelResto.tabel');
    }
}
