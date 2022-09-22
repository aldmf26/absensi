<?php

namespace App\Imports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\ToModel;

class KaryawanImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {       
      
        return new Karyawan([   
            'nama_karyawan' => $row[1],
            'tanggal_masuk' => $row[2],
            'departemen' => $row[3],
            'posisi' => $row[4],
        ]);
        
    }
}
