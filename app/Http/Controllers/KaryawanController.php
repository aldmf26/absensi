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
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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
            'karyawan' => Karyawan::join('tb_gaji', 'karyawan.id_karyawan', 'tb_gaji.id_karyawan')->join('departemen', 'karyawan.id_departemen', '=', 'departemen.id_departemen')->where('departemen.id_departemen', 'LIKE', '%' . '4' . '%')->orderBy('karyawan.id_karyawan', 'desc')->get(),
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
        if ($cek) {
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
        $karyawan = Karyawan::select('departemen.*', 'karyawan.*')->join('departemen', 'karyawan.id_departemen', '=', 'departemen.id_departemen')->where('departemen.id_departemen', '1')->orderBy('id_karyawan', 'desc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(8);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(13);
        $sheet->getColumnDimension('F')->setWidth(13);

        $sheet
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'ID KARYAWAN')
            ->setCellValue('C1', 'NAMA KARYAWAN')
            ->setCellValue('D1', 'TGL MASUK')
            ->setCellValue('E1', 'POSISI');
        // ->setCellValue('F1', 'RP M')
        // ->setCellValue('G1', 'RP E')
        // ->setCellValue('H1', 'RP SP')
        // ->setCellValue('I1', 'RP BULANAN');

        $kolom = 2;
        $no = 1;

        foreach ($karyawan as $k) {
            $totalKerja = new DateTime($k->tanggal_masuk);
            $today = new DateTime();
            $tKerja = $today->diff($totalKerja);
            $sheet
                ->setCellValue('A' . $kolom, $no++)
                ->setCellValue('B' . $kolom, $k->id_karyawan)
                ->setCellValue('C' . $kolom, $k->nama_karyawan)
                ->setCellValue('D' . $kolom, $k->tanggal_masuk)
                ->setCellValue('E' . $kolom, $k->posisi);
            // ->setCellValue('F' . $kolom, $k->rp_m == '' ? 0 : $k->rp_m)
            // ->setCellValue('G' . $kolom, $k->rp_e == '' ? 0 : $k->rp_e)
            // ->setCellValue('H' . $kolom, $k->rp_sp == '' ? 0 : $k->rp_sp)
            // ->setCellValue('I' . $kolom, $k->g_bulanan == '' ? 0 : $k->g_bulanan);
            $kolom++;
        }

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

        $batas = count($karyawan) + 1;
        $sheet->getStyle('A1:E' . $batas)->applyFromArray($style);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Karyawan Anak Laki.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function excelKaryawanAgrilaras()
    {
        $karyawan = Karyawan::join('tb_gaji', 'karyawan.id_karyawan', 'tb_gaji.id_karyawan')->join('departemen', 'karyawan.id_departemen', '=', 'departemen.id_departemen')->where('departemen.id_departemen', 'LIKE', '%' . '4' . '%')->orderBy('karyawan.id_karyawan', 'desc')->get();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(8);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(13);
        $sheet->getColumnDimension('F')->setWidth(13);

        $sheet
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'ID KARYAWAN')
            ->setCellValue('C1', 'NAMA KARYAWAN')
            ->setCellValue('D1', 'TGL MASUK')
            ->setCellValue('E1', 'POSISI')
            ->setCellValue('F1', 'RP M')
            ->setCellValue('G1', 'RP E')
            ->setCellValue('H1', 'RP SP')
            ->setCellValue('I1', 'RP BULANAN');

        $kolom = 2;
        $no = 1;
        foreach ($karyawan as $k) {
            $totalKerja = new DateTime($k->tanggal_masuk);
            $today = new DateTime();
            $tKerja = $today->diff($totalKerja);
            $sheet
                ->setCellValue('A' . $kolom, $no++)
                ->setCellValue('B' . $kolom, $k->id_karyawan)
                ->setCellValue('C' . $kolom, $k->nama_karyawan)
                ->setCellValue('D' . $kolom, $k->tanggal_masuk)
                ->setCellValue('E' . $kolom, $k->posisi)
                ->setCellValue('F' . $kolom, $k->rp_m == '' ? 0 : $k->rp_m)
                ->setCellValue('G' . $kolom, $k->rp_e == '' ? 0 : $k->rp_e)
                ->setCellValue('H' . $kolom, $k->rp_sp == '' ? 0 : $k->rp_sp)
                ->setCellValue('I' . $kolom, $k->g_bulanan == '' ? 0 : $k->g_bulanan);
            $kolom++;
        }

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

        $batas = count($karyawan) + 1;
        $sheet->getStyle('A1:I' . $batas)->applyFromArray($style);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Karyawan Agrilaras.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function importKaryawanAl(Request $r)
    {
        $file = $r->file('file');

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
        $spreadsheet = $reader->load($file);

        $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $kolom = 1;
         
    }

    public function importKaryawan(Request $request)
    {
        $file = $request->file('file');

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
        $spreadsheet = $reader->load($file);

        $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $kolom = 1;
        foreach ($sheet as $row) {
            if ($row['A'] == '' && $row['B'] == '' && $row['C'] == '' && $row['D'] == '' && $row['E'] == '' && $row['F'] == '' && $row['G'] == '' && $row['H'] == '') {
                continue;
            }
            if ($kolom > 1) {
                $data = [
                    'rp_m' => $row['F'],
                    'rp_e' => $row['G'],
                    'rp_sp' => $row['H'],
                    'g_bulanan' => $row['I'],
                ];

                Gaji::where('id_karyawan', $row['B'])->update($data);
            }
            $kolom++;
        }

        return redirect()->route('karyawanAgrilaras', ['id_departemen' => 4])->with('sukses', 'Data berhasil Diimport');
    }
}
