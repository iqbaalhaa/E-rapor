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
use Carbon\Carbon;
use App\Models\WaliKelas;
use App\Models\User;
use App\Models\CatatanWalikelas;
use App\Models\Ketidakhadiran;
use App\Models\Prestasi;
use App\Models\EkstrakurikulerSiswa;

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
        Carbon::setLocale('id');
        $tahun = TahunAkademik::where('is_active', 1)->first();
        $siswa = Siswa::findOrFail($siswa_id);
        $nilai = NilaiSiswa::where('siswa_id', $siswa_id)
                    ->where('tahun_akademik_id', $tahun->id)
                    ->with(['mapel', 'guru'])
                    ->get();
    
        $kelasSiswa = \App\Models\KelasSiswa::where('siswa_id', $siswa_id)
            ->where('tahun_akademik_id', $tahun->id)
            ->with('kelas')
            ->first();
        $kelas = $kelasSiswa->kelas;

        $wali = \App\Models\WaliKelas::where('kelas_id', $kelas->id)
                            ->where('tahun_akademik_id', $tahun->id)
                            ->with('guru')
                            ->first();
        $walikelas = $wali->guru ?? null;
        
        $kepsek = \App\Models\User::where('role', 'admin')->first();

        $tanggal_cetak = Carbon::now()->translatedFormat('d F Y');

        // Data Rapor Tambahan
        $catatan_walikelas = \App\Models\CatatanWalikelas::where('siswa_id', $siswa_id)
            ->where('tahun_akademik_id', $tahun->id)->first()->catatan ?? '';
        $ketidakhadiran = \App\Models\Ketidakhadiran::where('siswa_id', $siswa_id)
            ->where('tahun_akademik_id', $tahun->id)->first();
        $prestasi = \App\Models\Prestasi::where('siswa_id', $siswa_id)
            ->where('tahun_akademik_id', $tahun->id)->get();
        $ekstrakurikuler = \App\Models\EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('tahun_akademik_id', $tahun->id)->get();
    
        return Pdf::loadView('admin.rapor.pdf', compact(
            'siswa', 'nilai', 'kelas', 'tahun', 'walikelas', 'kepsek', 'tanggal_cetak',
            'catatan_walikelas', 'ketidakhadiran', 'prestasi', 'ekstrakurikuler'
        ))
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