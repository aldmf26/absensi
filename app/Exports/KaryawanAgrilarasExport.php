<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KaryawanAgrilarasExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Karyawan::select('id_karyawan','nama_karyawan','posisi','tanggal_masuk','nama_departemen')->join('departemen', 'karyawan.id_departemen', '=', 'departemen.id_departemen')->where('departemen.id_departemen', 'LIKE', '%'.'4'.'%')->orderBy('id_karyawan', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID Karyawan',
            'Nama Karyawan',
            'Posisi',
            'Tanggal Masuk',
            'Departemen'
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
  
        $batas = Karyawan::all();
        $batas = count($batas) + 1;
        return $sheet->getStyle('A1:E'.$batas)->applyFromArray($style);
    }
}
