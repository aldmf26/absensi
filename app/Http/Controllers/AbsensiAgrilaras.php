<?php

namespace App\Http\Controllers;

use App\Models\Absensi_Agrilaras;
use App\Models\Karyawan;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class AbsensiAgrilaras extends Controller
{
    public function detail_agrilaras(Request $request)
    {
        $agent = new Agent();
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
        $tg = $request->tgl;
        if (empty($tg)) {
            $tgl = date('Y-m-d');
        } else {
            $tgl = $tg;
        }
        // dd($tahun);

        // select('absensi_agrilaras.*','karyawan.*')
        // ->join('karyawan','absensi_agrilaras.id_karyawan', '=', 'karyawan.id_karyawan')->orderBy('id', 'desc'),
        $data = [
            'title' => 'Absensi',
            'absensi' => Absensi_Agrilaras::select('absensi_agrilaras.*', 'karyawan.nama_karyawan', 'users.nama')->join('karyawan', 'absensi_agrilaras.id_karyawan', '=', 'karyawan.id_karyawan')->join('users', 'absensi_agrilaras.admin', '=', 'users.id')->where('absensi_agrilaras.tanggal_masuk', 'LIKE', '%' . '2022-03-01' . '%')->orderBy('id', 'desc')->get(),
            'karyawan' => Karyawan::where('id_departemen', 'LIKE', '%' . '4' . '%')->get(),
            'tahun' => Absensi_Agrilaras::all(),
            'bulan' => $bulan,
            'tgl' => $tgl,
            'tahun_2' => $tahun,
            's_tahun' => DB::select(DB::raw("SELECT YEAR(a.tanggal_masuk) as tahun FROM absensi_agrilaras as a group by YEAR(a.tanggal_masuk)")),
            'status' => Status::all(),
            'id_departemen' => $id_departemen,
            'shift' => Status::all(),
        ];
        if ($agent->isMobile()) {
            return view('absenMobile.absen', ['id_departemen' => 4], $data);
        } else {
            return view('absensi_agrilaras.absensi_agrilaras_detail', ['id_departemen' => 4], $data);
        }
    }

    public function tabelAbsenM(Request $request)
    {
        $tg = $request->tgl;
        if (empty($tg)) {
            $tgl = date('Y-m-d');
        } else {
            $tgl = $tg;
        }
        $data = [
            'tb_karyawan' => Karyawan::where('id_departemen', 'LIKE', '%' . '4' . '%')->get(),
            'tgl' => $tgl,
            'shift' => Status::all(),
        ];
        return view('absenMobile.tabelAbsen', $data);
    }

    public function addAbsenM(Request $request)
    {
        $status = $request->ket;
        $id_karyawan = $request->id_karyawan;
        $tgl = $request->tgl;
        $ada = Absensi_Agrilaras::where([
            ['id_karyawan', $id_karyawan],
            ['status', $status],
            ['tanggal_masuk', $tgl],
        ])->first();

        if ($ada) {
            return true;
        } else {
            $data =  [
                'status' => $request->ket,
                'id_karyawan' => $request->id_karyawan,
                'tanggal_masuk' => $request->tgl,
                'admin' => Auth::user()->id,
            ];
            Absensi_Agrilaras::create($data);
        }
    }

    public function deleteAbsenM(Request $request)
    {
        Absensi_Agrilaras::where('id', $request->id_absen)->delete();
    }

    public function updateAbsenM(Request $request)
    {
        $data = [
            'status' => $request->ket2,
        ];

        Absensi_Agrilaras::where('id', $request->id_absen_edit)->update($data);
        return true;
    }

    public function ubah_bulan(Request $request)
    {
        dd($request->bulan);
    }

    public function input_agrilaras(Request $request)
    {
        $cek = Absensi_Agrilaras::where([['id_karyawan', $request->id_karyawan], ['tanggal_masuk', $request->tanggal_masuk]])->first();
        if ($cek) {
            return true;
        } else {
            $data = [
                'id_karyawan' => $request->id_karyawan,
                'status' => $request->status,
                'tanggal_masuk' => $request->tanggal,
                'admin' => Auth::user()->id,
                // 'admin' => $request->admin,
            ];


            Absensi_Agrilaras::create($data);
            return true;
        }
    }

    public function delete_agrilaras(Request $request)
    {
        Absensi_Agrilaras::where('id', $request->id_absen)->delete();
        return true;
    }

    public function downloadAbsAgri(Request $request)
    {

        $bulan = $request->bulanDwn;
        $tahun = $request->tahunDwn;
        $data = [
            'absensi' => DB::select(DB::raw("SELECT a.*, COUNT(a.status) AS total_masuk,b.nama_karyawan
            FROM absensi_agrilaras AS a
            LEFT JOIN karyawan as b on b.id_karyawan = a.id_karyawan
            WHERE MONTH(a.tanggal_masuk) = $bulan AND YEAR(a.tanggal_masuk) = $tahun
            GROUP BY a.id_karyawan ORDER BY a.id_karyawan DESC")),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'karyawan' => Karyawan::where('id_departemen', 'LIKE', '%' . '4' . '%')->orderBy('id_karyawan', 'DESC')->get(),
            // 'absensi' => Absensi_Agrilaras::select('absensi_agrilaras.*', 'karyawan.*')->join('karyawan', 'absensi_agrilaras.id_karyawan', '=', 'karyawan.id_karyawan')->groupBy('absensi_agrilaras.id_karyawan')->get(),
            // 'total' => Absensi_Agrilaras::>where('status', '=', 'M')->get()
            // 'absensi' => DB::table('v_absensi_agrilaras')->whereMonth('tanggal_masuk', '=', '02')->whereYear('tanggal_masuk', '=', '2022')->get()
        ];

        return view('absensi_agrilaras.excel', $data);
    }

    public function gajiAgrilaras(Request $r)
    {
        if ($r->tgl1 == '') {
            $tgl1 = date('Y-m-1');
            $tgl2 = date('Y-m-d');
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }
        $query = DB::select("SELECT a.id_karyawan,a.nama_karyawan,b.g_bulanan, SUM(d.qty_m) as qty_m, SUM(d.qty_e) as qty_e, SUM(d.qty_sp) as qty_sp, SUM(d.qty_m * b.rp_m) as ttl_gaji_m, SUM(d.qty_e * b.rp_e) as ttl_gaji_e, SUM(d.qty_sp * b.rp_sp) as ttl_gaji_sp
        FROM `karyawan` as a
        LEFT JOIN tb_gaji as b ON a.id_karyawan = b.id_karyawan
        LEFT JOIN 
        (SELECT c.id_karyawan, c.status, 
         IF(c.status = 'M', COUNT(c.status),0) as qty_m,
         IF(c.status = 'E', COUNT(c.status),0) as qty_e, 
         IF(c.status = 'SP', COUNT(c.status),0) as qty_sp FROM absensi_agrilaras as c 
         WHERE c.tanggal_masuk BETWEEN '$tgl1' AND '$tgl2' 
         GROUP BY c.id_karyawan, c.status) as d on d.id_karyawan = a.id_karyawan 
         WHERE a.id_departemen = 4
         GROUP BY a.id_karyawan
         ORDER BY a.id_karyawan desc;");
        $data = [
            'title' => 'Gaji Agrilaras',
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'id_departemen' => 4,
            'shift' => Status::all(),
            'hasil' => $query,
        ];

        return view('gaji.gaji', $data);
    }

    public function exportGaji(Request $r)
    {
        if ($r->tgl1 == '') {
            $tgl1 = date('Y-m-1');
            $tgl2 = date('Y-m-d');
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }

        $query = DB::select("SELECT a.id_karyawan,a.nama_karyawan,b.g_bulanan, SUM(d.qty_m) as qty_m, SUM(d.qty_e) as qty_e, SUM(d.qty_sp) as qty_sp, SUM(d.qty_m * b.rp_m) as ttl_gaji_m, SUM(d.qty_e * b.rp_e) as ttl_gaji_e, SUM(d.qty_sp * b.rp_sp) as ttl_gaji_sp
        FROM `karyawan` as a
        LEFT JOIN tb_gaji as b ON a.id_karyawan = b.id_karyawan
        LEFT JOIN 
        (SELECT c.id_karyawan, c.status, 
         IF(c.status = 'M', COUNT(c.status),0) as qty_m,
         IF(c.status = 'E', COUNT(c.status),0) as qty_e, 
         IF(c.status = 'SP', COUNT(c.status),0) as qty_sp FROM absensi_agrilaras as c 
         WHERE c.tanggal_masuk BETWEEN '$tgl1' AND '$tgl2' 
         GROUP BY c.id_karyawan, c.status) as d on d.id_karyawan = a.id_karyawan 
         WHERE a.id_departemen = 4
         GROUP BY a.id_karyawan
         ORDER BY a.id_karyawan desc");

        $status = Status::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(13);
        $sheet->getColumnDimension('F')->setWidth(13);

        $sheet
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'NAMA KARYAWAN')
            ->setCellValue('C1', 'TOTAL M')
            ->setCellValue('D1', 'TOTAL E')
            ->setCellValue('E1', 'TOTAL SP')
            ->setCellValue('F1', 'TOTAL ABSEN')
            ->setCellValue('G1', 'GAJI TOTAL M')
            ->setCellValue('H1', 'GAJI TOTAL E')
            ->setCellValue('I1', 'GAJI TOTAL SP')
            ->setCellValue('J1', 'GAJI BULANAN');

        $kolom = 2;
        $no = 1;
        $ttlGaji = 0;
        $ttlAbsen = 0;
        $ttlBulanan = 0;
        foreach ($query as $k) {
            $ttlAbsen = $k->qty_m + $k->qty_e + $k->qty_sp;
            $sheet
                ->setCellValue('A' . $kolom, $no++)
                ->setCellValue('B' . $kolom, $k->nama_karyawan)
                ->setCellValue('C' . $kolom, $k->qty_m == '' ? 0 : $k->qty_m)
                ->setCellValue('D' . $kolom, $k->qty_e == '' ? 0 : $k->qty_e)
                ->setCellValue('E' . $kolom, $k->qty_sp == '' ? 0 : $k->qty_sp)
                ->setCellValue('F' . $kolom, $ttlAbsen == '' ? 0 : $ttlAbsen)
                ->setCellValue('G' . $kolom, $k->ttl_gaji_m == '' ? 0 : $k->ttl_gaji_m)
                ->setCellValue('H' . $kolom, $k->ttl_gaji_e)
                ->setCellValue('I' . $kolom, $k->ttl_gaji_sp)
                ->setCellValue('J' . $kolom, $k->g_bulanan);
            $ttlGaji += $k->ttl_gaji_m;
            $ttlBulanan += $k->g_bulanan;
            $kolom++;
        }
        $b = count($query) + 2;
        $sheet->setCellValue('F'. $b, 'TOTAL');
        $sheet->setCellValue('G'. $b, $ttlGaji);
        $sheet->setCellValue('J'. $b, $ttlBulanan);
        
        $sheet->getStyle('F'.$b)->getFont()->setBold( true );
        $sheet->getStyle('G'.$b)->getFont()->setBold( true );
        $sheet->getStyle('J'.$b)->getFont()->setBold( true );
        

        $writer = new Xlsx($spreadsheet);
        $style = [
            'borders' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ];

        $batas = count($query) + 1;
        $sheet->getStyle('A1:J'.$batas)->applyFromArray($style);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Gaji Agrilaras.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
