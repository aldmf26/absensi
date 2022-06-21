<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
    protected $table = 'tb_gaji';
    protected $fillable = [
        'id_karyawan','rp_m', 'g_bulanan', 'rp_e', 'rp_sp'
    ];
}