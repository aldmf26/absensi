<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Absensi_Salon;
use App\Models\Jenis;
use App\Models\Karyawan;
use App\Models\Pemakai;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsensiSalonController extends Controller
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
               'absensi' => Absensi_Salon::select('absensi_salon.*','karyawan.*')->join('karyawan','absensi_salon.id_karyawan', '=', 'karyawan.id_karyawan')->join('departemen', 'karyawan.id_departemen', '=', 'departemen.id_departemen')->where('id_departemen', 'LIKE', '%'.'2'.'%')->orderBy('id', 'desc'),
               'karyawan' => Karyawan::where('id_departemen', 'LIKE', '%'.'2'.'%')->get(),
               'status' => Status::all(),
               'aktif' => 2,
               'id_departemen' => $id_departemen
           ];

           return view('absensi_salon.absensi_salon',$data);
       }
 	
    }
    
    public function detail_salon(Request $request)
    {
        $id_departemen = $request->id_departemen;
        $id_user = Auth::user()->id;

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
        // select('absensi_salon.*','karyawan.*')
        // ->join('karyawan','absensi_salon.id_karyawan', '=', 'karyawan.id_karyawan')->orderBy('id', 'desc'),
        $data = [
            'title' => 'Absensi',
            'absensi' => Absensi_Salon::select('absensi_salon.*', 'karyawan.nama_karyawan', 'users.nama')->join('karyawan', 'absensi_salon.id_karyawan', '=', 'karyawan.id_karyawan')->join('users', 'absensi_salon.admin', '=', 'users.id')->where('absensi_salon.tanggal_masuk', 'LIKE', '%'.'2022-03-01'.'%')->orderBy('id', 'desc')->get(),
            'karyawan' => Karyawan::where('id_departemen', 'LIKE', '%'.'2'.'%')->get(),
            'tahun' => Absensi_Salon::all(),
            'detail_bulan' => $request->bulan,
            'tahun' => Absensi_Salon::all(),
            'bulan' => $bulan,
            'tahun_2' => $tahun,
            's_tahun' => DB::select(DB::raw("SELECT YEAR(a.tanggal_masuk) as tahun FROM absensi_salon as a group by YEAR(a.tanggal_masuk)")),
            'status' => Status::all(),
            'aktif' => 2,
            'id_departemen' => $id_departemen
        ];

       

        return view('absensi_salon.absensi_salon_detail', ['id_departemen' => 2],$data);
    }

    public function add_salon(Request $request)
    {
        
        // Absensi_Salon::where('id_karyawan',$request->id_karyawan)->delete();
        $data = [
            'id_karyawan' => $request->id_karyawan,
            'status' => $request->status,
            'tanggal_masuk' => $request->tanggal_masuk,
            'admin' => Auth::user()->id,
            'id_departemen' => $request->departemen
        ];
        $cek = Absensi_Salon::where('tanggal_masuk',$request->tanggal_masuk)->where('id_karyawan', $request->id_karyawan)->first();
        
        if($cek){
            return redirect()->route('add_edit_salon', ['id_departemen' => 2])->with('error', 'Karyawan Sudah Absen');
        } else {
            Absensi_Salon::create($data);
        return redirect()->route('add_edit_salon', ['id_departemen' => 2])->with('sukses', 'Berhasil Tambah Data Absen Salon');
        }
        


        
        

    }

    public function edit_salon(Request $request)
    {
        $data = [
            'id_karyawan' => $request->id_karyawan,
            'status' => $request->status,
            'tanggal_masuk' => $request->tanggal_masuk,
            'admin' => Auth::user()->id,

        ];

        Absensi_Salon::where('id',$request->id_absen)->update($data);

      
        return redirect()->route('add_edit_salon', ['id_departemen' => 2])->with('sukses', 'Berhasil Ubah Data Absen Salon');
    }

    public function add_edit_salon(Request $request)
    {
        $id_departemen = $request->id_departemen;
        $id_user = Auth::user()->id;
        // select('absensi_salon.*','karyawan.*')
        // ->join('karyawan','absensi_salon.id_karyawan', '=', 'karyawan.id_karyawan')->orderBy('id', 'desc'),
        $data = [
            'title' => 'Absensi',
            'absensi' => Absensi_Salon::select('absensi_salon.*', 'karyawan.nama_karyawan', 'users.nama')->join('karyawan', 'absensi_salon.id_karyawan', '=', 'karyawan.id_karyawan')->join('users', 'absensi_salon.admin', '=', 'users.id')->orderBy('id', 'desc')->get(),
            'karyawan' => Karyawan::where('id_departemen', 'LIKE', '%'.'2'.'%')->get(),
            'status' => Status::all(),
            'aktif' => 2,
            'id_departemen' => $id_departemen
        ];
        return view('absensi_salon.absensi_salon_edit',$data);
    }

    public function input_salon(Request $request)
    {
       $data = [
        'id_karyawan' => $request->id_karyawan,
        'status' => $request->status,
        'tanggal_masuk' => $request->tanggal,
        'admin' => Auth::user()->id,
        // 'admin' => $request->admin,
       ];
       

       Absensi_Salon::create($data);
       return redirect()->route('detail_salon',['id_departemen' => 2, 'bulan' => $request->bulan, 'tahun' => $request->tahun]);

    }

    public function update_salon(Request $request)
    {
        $data = [
            'status' => $request->status,
        ];

        Absensi_Salon::where('id',$request->id_absen)->update($data);
        return redirect()->route('detail_salon', ['id_departemen' => 2]);
    }

    public function delete_salon(Request $request)
    {
        Absensi_Salon::where('id',$request->id_absen)->delete();
        return true;
    }
}
