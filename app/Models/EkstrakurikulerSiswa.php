<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkstrakurikulerSiswa extends Model
{
    use HasFactory;

    protected $table = 'ekstrakurikuler_siswa';

    protected $fillable = [
        'siswa_id',
        'tahun_akademik_id',
        'nama_ekskul',
        'nilai',
        'keterangan',
    ];
}
