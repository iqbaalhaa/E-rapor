<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\TahunAkademik;
use App\Models\Siswa;
use App\Models\NilaiSiswa;
use App\Models\KelasSiswa;
use Barryvdh\DomPDF\Facade\Pdf;

class CetakRaporController extends Controller
{
    public function index()
    {
        $tahun = TahunAkademik::where('is_active', 1)->first();
        $kelas = Kelas::all();
        
        return view('admin.rapor.index', compact('kelas', 'tahun'));
    }

    public function show($siswa_id)
    {
        $tahun = TahunAkademik::where('is_active', 1)->first();
        $siswa = Siswa::findOrFail($siswa_id);
        $nilai = NilaiSiswa::where('siswa_id', $siswa_id)
                    ->where('tahun_akademik_id', $tahun->id)
                    ->with(['mapel', 'guru'])
                    ->get();
    
        $kelas = KelasSiswa::where('siswa_id', $siswa_id)
                    ->where('tahun_akademik_id', $tahun->id)
                    ->with('kelas')
                    ->first()
                    ->kelas;
    
        return Pdf::loadView('admin.rapor.pdf', compact('siswa', 'nilai', 'kelas', 'tahun'))
                    ->stream('rapor-'.$siswa->nama.'.pdf');
    }

    public function cetakKelas($kelas_id)
    {
        $tahun = TahunAkademik::where('is_active', 1)->first();
        $kelas = Kelas::findOrFail($kelas_id);

        $siswa = KelasSiswa::where('kelas_id', $kelas_id)
                    ->where('tahun_akademik_id', $tahun->id)
                    ->with('siswa')
                    ->get();

        $data = [];

        foreach ($siswa as $s) {
            $nilai = NilaiSiswa::where('siswa_id', $s->siswa_id)
                        ->where('tahun_akademik_id', $tahun->id)
                        ->with(['mapel', 'guru'])
                        ->get();

            $data[] = [
                'siswa' => $s->siswa,
                'kelas' => $kelas,
                'tahun' => $tahun,
                'nilai' => $nilai,
            ];
        }

        $pdf = Pdf::loadView('admin.rapor.kelas', ['data' => $data])->setPaper('A4');
        return $pdf->stream('rapor-kelas-'.$kelas->nama_kelas.'.pdf');
    }
} 