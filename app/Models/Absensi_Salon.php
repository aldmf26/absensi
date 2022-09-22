<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi_Salon extends Model
{
    use HasFactory;
    protected $table = 'absensi_salon';
    protected $fillable = [
        'id_karyawan','status','tanggal_masuk', 'admin'
    ];
}
