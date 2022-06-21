<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemakai extends Model
{
    use HasFactory;
    protected $table = 'pemakai_jasa';
    protected $fillable = [
        'pemakai','keterangan'
    ];
}
