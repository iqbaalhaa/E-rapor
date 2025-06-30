<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ketidakhadiran extends Model
{
    use HasFactory;

    protected $table = 'ketidakhadiran';

    protected $fillable = [
        'siswa_id',
        'tahun_akademik_id',
        'sakit',
        'izin',
        'tanpa_keterangan',
    ];
}
