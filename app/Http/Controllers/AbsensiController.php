<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiAgriExport;
use App\Models\Absensi;
use App\Models\Jenis;
use App\Models\Karyawan;
use App\Models\Login;
use App\Models\Pemakai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;
use App\Exports\AbsensiPertanggalExport;

class AbsensiController extends Controller
{
    //
    public function index(Request $request)
    {
        // cek user ada menu apa aja
        $id_departemen = 1;
        $id_user = Auth::user()->id;
        $id_menu = DB::table('permisi')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 3)->first();

        if (empty($id_menu)) {
            // return redirect(route('login'));
            return view('login.login');
        } else {
            $tglDari = $request->tglDari;
            $tglSampai = $request->tglSampai;
            if (empty($tglDari)) {
                $dari = date('Y-m-1');
                $sampai = date('Y-m-d');
            } else {
                $dari = $tglDari;
                $sampai = $tglSampai;
            }
            $tglHariIni = date('Y-m-d');
            $data = [
                'title' => 'Absensi',
                'absensi' => Absensi::select('absensi.*', 'karyawan.nama_karyawan', 'karyawan.id_departemen', 'jenis_pekerjaan.jenis_pekerjaan', 'pemakai_jasa.pemakai')->join('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id_karyawan')->join('jenis_pekerjaan', 'absensi.id_jenis_pekerjaan', '=', 'jenis_pekerjaan.id')->join('pemakai_jasa', 'absensi.id_pemakai', '=', 'pemakai_jasa.id_pemakai')->where('id_departemen', '1')->where('absensi.jam_akhir', '!=', '')->whereBetween('absensi.tanggal', [$dari, $sampai])->orderBy('absensi.tanggal', 'desc')->get(),
                'karyawan' => DB::select("SELECT *, a.id_karyawan as idk, c.jam_awal as jaw, c.jam_akhir as jak FROM `karyawan` as a
                LEFT JOIN absensi as c on a.id_karyawan = c.id_karyawan
                WHERE a.id_karyawan not in (SELECT b.id_karyawan from absensi as b where b.tanggal = '$tglHariIni') AND a.id_departemen = 1;"),
                'karyawanAbsen' => DB::select("SELECT *,a.id_karyawan as idk FROM `absensi` as a
                LEFT JOIN karyawan as c on a.id_karyawan = c.id_karyawan
                WHERE a.jam_akhir is null AND c.id_departemen = 1 AND a.tanggal = '$tglHariIni'"),
                'karyawan2' => DB::select("SELECT *, a.id_karyawan as idk FROM `karyawan` as a
                WHERE a.id_departemen = 1;"),
                'pemakai' => Pemakai::all(),
                'jenis_pekerjaan' => Jenis::all(),
                'aktif' => 2,
                'dari' => $dari,
                'sampai' => $sampai,
                'id_departemen' => $id_departemen
            ];
            return view('absensi.absensi',['tglDari => '.$dari.','.'tglSampai' => $sampai], $data);
        }
    }

    

    public function addAbsensi(Request $request)
    {
        
        $id_karyawan = $request->id_karyawan;
        $id_jenis = $request->id_jenis;
        $id_pemakai = $request->id_pemakai;
        $tanggal = $request->tanggal;
        $jam_awal = $request->jam_awal;
        $jam_akhir = $request->jam_akhir;
        $keterangan = $request->keterangan;

        $id_karyawan2 = $request->id_karyawan2;
        $id_jenis2 = $request->id_jenis2;
        $id_pemakai2 = $request->id_pemakai2;
        $tanggal2 = $request->tanggal2;
        $jam_awal2 = $request->jam_awal2;
        $jam_akhir2 = $request->jam_akhir2;
        $keterangan2 = $request->keterangan2;

        $simpan = $request->simpan;
        $cekJamAkhir = Absensi::where([['jam_akhir', ''],['tanggal', date('Y-m-d')]])->get();
        if(empty($id_karyawan2)) {

        } else {
            for ($i = 0; $i < count($id_karyawan2); $i++) {
                $cekData1 = Absensi::where([['id_karyawan', $id_karyawan2[$i]], ['tanggal', date('Y-m-d')]])->first();
                if($cekData1) {
                    $data1 = [
                        'id_jenis_pekerjaan' => $id_jenis2[$i],
                        'id_pemakai' => $id_pemakai2[$i],
                        'tanggal' => $tanggal2[$i],
                        'jam_awal' => $jam_awal2[$i],
                        'jam_akhir' => null,
                        'ket' => $keterangan2[$i],
                    ];
                    Absensi::where('id_absen', $cekData1->id_absen)->update($data1);

                    $data2 = [
                        'id_karyawan' => $id_karyawan2[$i],
                        'id_jenis_pekerjaan' => $id_jenis2[$i],
                        'id_pemakai' => $id_pemakai2[$i],
                        'tanggal' => $tanggal2[$i],
                        'jam_awal' => $jam_awal2[$i],
                        'jam_akhir' => $jam_akhir2[$i],
                        'ket' => $keterangan2[$i],
                    ];
                    Absensi::create($data2);
                }
                
            }
        }
        
        if(empty($id_karyawan)) {

        } else {
            
            for ($i = 0; $i < count($id_karyawan); $i++) {
                if(empty($request->id_absen[$i])) {
                    
                            $data = [
                                'id_karyawan' => $id_karyawan[$i],
                                'id_jenis_pekerjaan' => $id_jenis[$i],
                                'id_pemakai' => $id_pemakai[$i],
                                'tanggal' => $tanggal[$i],
                                'jam_awal' => $jam_awal[$i],
                                'jam_akhir' => $jam_akhir[$i],
                                'ket' => $keterangan[$i],
                            ];
                
                            Absensi::create($data);
                } else {
                    $data = [
                        'id_jenis_pekerjaan' => $id_jenis[$i],
                        'id_pemakai' => $id_pemakai[$i],
                        'tanggal' => $tanggal[$i],
                        'jam_awal' => $jam_awal[$i],
                        'jam_akhir' => $jam_akhir[$i],
                        'ket' => $keterangan[$i],
                    ];
        
                    Absensi::where('id_absen', $request->id_absen[$i])->update($data);
                }
                
                // if($request->id_absen[$i] != '') {
                //     $data = [
                //         'id_jenis_pekerjaan' => $id_jenis[$i],
                //         'id_pemakai' => $id_pemakai[$i],
                //         'tanggal' => $tanggal[$i],
                //         'jam_awal' => $jam_awal[$i],
                //         'jam_akhir' => $jam_akhir[$i],
                //         'ket' => $keterangan[$i],
                //     ];
        
                //     Absensi::where('id_absen', $request->id_absen[$i])->update($data);
                // } else {
                    
                // }

               

                // $cekData1 = Absensi::where([['id_karyawan', $id_karyawan[$i]], ['tanggal', date('Y-m-d')], ['jam_akhir', '']])->first();
                // if($cekData1) {
                    

                //     // $data2 = [
                //     //     'id_karyawan' => $id_karyawan[$i],
                //     //     'id_jenis_pekerjaan' => $id_jenis[$i],
                //     //     'id_pemakai' => $id_pemakai[$i],
                //     //     'tanggal' => $tanggal[$i],
                //     //     'jam_awal' => $jam_awal[$i],
                //     //     'jam_akhir' => $jam_akhir[$i],
                //     //     'ket' => $keterangan[$i],
                //     // ];
        
                //     // Absensi::create($data2);
                // } else {
                    
                // }
            
                
            }
        }
        

        
        return redirect()->route('absensi', ['id_departemen' => 1]);
    }

    public function editAbsensi(Request $request)
    {
        $data = [
            'id_karyawan' => $request->id_karyawan,
            'id_jenis_pekerjaan' => $request->id_jenis,
            'id_pemakai' => $request->id_pemakai,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ];

        Absensi::where('id', $request->id)->update($data);

        
        return redirect()->route('absensi', ['tglDari' => $request->tglDari, 'tglSampai' => $request->tglSampai]);
    }

    public function deleteAbsensi(Request $request)
    {
        Absensi::where('id_absen', $request->id)->delete();

        return redirect()->route('absensi', ['id_departemen' => 1, 'tglDari' => $request->tglDari, 'tglSampai' => $request->tglSampai]);
    }

    public function excel()
    {
        // $data = [
        //     'absensi' => Absensi::select('absensi.*', 'karyawan.nama_karyawan', 'karyawan.id_departemen', 'jenis_pekerjaan.jenis_pekerjaan', 'pemakai_jasa.pemakai')->join('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id_karyawan')->join('jenis_pekerjaan', 'absensi.id_jenis_pekerjaan', '=', 'jenis_pekerjaan.id')->join('pemakai_jasa', 'absensi.id_pemakai', '=', 'pemakai_jasa.id_pemakai')->where('id_departemen', 'LIKE', '%' . '1' . '%')->orderBy('id', 'desc')->get(),
        // ];

        // return view('absensi.excel', $data);
        return Excel::download(new AbsensiExport, 'Absensi Anak Laki.xlsx');
    }

    public function exportPertanggal(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
       
        // $data = [
        //     'absensi' => Absensi::select('absensi.*', 'karyawan.nama_karyawan', 'karyawan.id_departemen', 'jenis_pekerjaan.jenis_pekerjaan', 'pemakai_jasa.pemakai')->join('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id_karyawan')->join('jenis_pekerjaan', 'absensi.id_jenis_pekerjaan', '=', 'jenis_pekerjaan.id')->join('pemakai_jasa', 'absensi.id_pemakai', '=', 'pemakai_jasa.id_pemakai')->where('id_departemen', 1)->whereBetween('absensi.tanggal', [$dari, $sampai])->orderBy('id', 'desc')->get(),
        // ];

        // return view('absensi.excel', $data);
        return Excel::download(new AbsensiPertanggalExport($dari, $sampai), 'Absensi Anak Laki Pertanggal.xlsx');
    }

    public function hapusPertanggal(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;

        Absensi::whereBetween('absensi.tanggal', [$dari, $sampai])->delete();
        return redirect()->route('absensi', ['id_departemen' => 1, 'tglDari' => $request->tglDari, 'tglSampai' => $request->tglSampai])->with('error', 'Berhasil hapus absen '.$dari.' - '.$sampai);
    }
}
