<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiPertanggalExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $dari;
    protected $sampai;
    function __construct($dari, $sampai)
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
    }
    public function collection()
    {
        return Absensi::select('absensi.id_karyawan','absensi.tanggal','karyawan.nama_karyawan','jenis_pekerjaan.jenis_pekerjaan','pemakai_jasa.pemakai', 'absensi.keterangan')->join('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id_karyawan')->join('jenis_pekerjaan', 'absensi.id_jenis_pekerjaan', '=', 'jenis_pekerjaan.id')->join('pemakai_jasa', 'absensi.id_pemakai', '=', 'pemakai_jasa.id_pemakai')->where('id_departemen', 'LIKE', '%' . '1' . '%')->whereBetween('absensi.tanggal', [$this->dari, $this->sampai])->orderBy('absensi.tanggal', 'asc')->get();
    }
    public function headings(): array
    {
        return [
            'ID Karyawan',
            'Tanggal Masuk',
            'Nama',
            'Jenis Pekerjaan',
            'Pemakai Jasa',
            'Keterangan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $style = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ];
        $batas = Absensi::all();
        $batas = count($batas);
        return $sheet->getStyle('A1:F'.$batas)->applyFromArray($style);
    }
}
