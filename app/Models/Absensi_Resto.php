<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi_Resto extends Model
{
    use HasFactory;
    protected $table = 'absensi_resto';
    protected $fillable = [
        'id_karyawan','status','tanggal_masuk', 'admin'
    ];
}
