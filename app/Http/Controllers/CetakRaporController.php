<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasSiswa;
use App\Models\TahunAkademik;
use App\Models\WaliKelas;
use App\Models\Siswa;
use App\Models\NilaiSiswa;
use Barryvdh\DomPDF\Facade\Pdf;

class CetakRaporController extends Controller
{
    public function index()
    {
        $tahun = TahunAkademik::where('is_active', 1)->first();
        $wali = WaliKelas::where('guru_id', auth()->user()->guru->id)
                  ->where('tahun_akademik_id', $tahun->id)
                  ->first();

        $siswa = KelasSiswa::where('kelas_id', $wali->kelas_id)
                  ->where('tahun_akademik_id', $tahun->id)
                  ->with('siswa')
                  ->get();

        return view('walikelas.rapor.index', compact('siswa'));
    }

    public function show($siswa_id)
    {
        $tahun = TahunAkademik::where('is_active', 1)->first();
        $siswa = Siswa::findOrFail($siswa_id);
        $nilai = NilaiSiswa::where('siswa_id', $siswa_id)
                    ->where('tahun_akademik_id', $tahun->id)
                    ->with(['mapel', 'guru'])
                    ->get();
    
        // Tambahkan ini
        $kelas = \App\Models\KelasSiswa::where('siswa_id', $siswa_id)
                    ->where('tahun_akademik_id', $tahun->id)
                    ->with('kelas')
                    ->first()
                    ->kelas;
    
        return Pdf::loadView('walikelas.rapor.pdf', compact('siswa', 'nilai', 'kelas', 'tahun'))
                    ->stream('rapor-'.$siswa->nama.'.pdf');
    }
}
