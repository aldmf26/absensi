<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KaryawanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Karyawan::select('id_karyawan','nama_karyawan','tanggal_masuk','nama_departemen')->join('departemen', 'karyawan.id_departemen', '=', 'departemen.id_departemen')->where('departemen.id_departemen',1)->orderBy('id_karyawan', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID Karyawan',
            'Nama Karyawan',
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
        return $sheet->getStyle('A1:D'.$batas)->applyFromArray($style);
    }
}
