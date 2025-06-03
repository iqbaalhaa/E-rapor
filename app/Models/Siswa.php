<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nama',
        'nis',
        'nisn',
        'email',
        'jenis_kelamin',
        'no_hp',
    ];

    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswa', 'siswa_id', 'kelas_id')
            ->withPivot('tahun_akademik_id')
            ->withTimestamps();
    }

    public function tahunAkademik()
    {
        return $this->belongsToMany(TahunAkademik::class, 'kelas_siswa', 'siswa_id', 'tahun_akademik_id')
            ->withTimestamps();
    }
}
