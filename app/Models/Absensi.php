<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensi';
    protected $fillable = [
        'id_karyawan','id_jenis_pekerjaan','id_pemakai','tanggal', 'ket','jam_awal','jam_akhir','status'
    ];
}
