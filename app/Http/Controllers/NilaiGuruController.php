<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NilaiSiswa;
use App\Models\KelasSiswa;
use App\Models\WaliKelas;
use App\Models\Siswa;
use App\Models\TahunAkademik;

class NilaiGuruController extends Controller
{
    public function index()
    {
        $tahun = TahunAkademik::where('is_active', 1)->first();
        $guru_id = auth()->user()->guru->id ?? null;

        $wali = WaliKelas::where('guru_id', $guru_id)
                ->where('tahun_akademik_id', $tahun->id)
                ->first();

        $kelas_id = $wali->kelas_id ?? null;

        $siswa = KelasSiswa::where('kelas_id', $kelas_id)
                  ->where('tahun_akademik_id', $tahun->id)
                  ->with('siswa')
                  ->get();

        return view('walikelas.nilai.index', compact('siswa', 'tahun'));
    }

    public function edit($siswa_id)
    {
        $tahun = TahunAkademik::where('is_active', 1)->first();
        $nilai = NilaiSiswa::where('siswa_id', $siswa_id)
                  ->where('tahun_akademik_id', $tahun->id)
                  ->with(['mapel', 'guru'])
                  ->get();

        $siswa = Siswa::findOrFail($siswa_id);

        return view('walikelas.nilai.edit', compact('nilai', 'siswa'));
    }

    public function update(Request $request, $siswa_id)
    {
        foreach ($request->nilai as $nilai_id => $data) {
            NilaiSiswa::where('id', $nilai_id)->update([
                'nilai_pengetahuan' => $data['pengetahuan'],
                'nilai_keterampilan' => $data['keterampilan'],
                'deskripsi' => $data['deskripsi'],
            ]);
        }

        return redirect()->route('nilai-guru.index')->with('success', 'Nilai berhasil diperbarui.');
    }
}
