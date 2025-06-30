<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanWalikelas extends Model
{
    use HasFactory;

    protected $table = 'catatan_walikelas';

    protected $fillable = [
        'siswa_id',
        'tahun_akademik_id',
        'catatan',
    ];
}
