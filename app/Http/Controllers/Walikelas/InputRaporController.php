<?php

namespace App\Http\Controllers\Walikelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\TahunAkademik;
use App\Models\CatatanWalikelas;
use App\Models\Ketidakhadiran;
use App\Models\Prestasi;
use App\Models\EkstrakurikulerSiswa;

class InputRaporController extends Controller
{
    public function edit($siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);
        $tahun = TahunAkademik::where('is_active', 1)->first();

        $catatan = CatatanWalikelas::firstOrCreate(
            ['siswa_id' => $siswa_id, 'tahun_akademik_id' => $tahun->id]
        );

        $ketidakhadiran = Ketidakhadiran::firstOrCreate(
            ['siswa_id' => $siswa_id, 'tahun_akademik_id' => $tahun->id],
            ['sakit' => 0, 'izin' => 0, 'tanpa_keterangan' => 0]
        );

        $prestasi = Prestasi::where('siswa_id', $siswa_id)
            ->where('tahun_akademik_id', $tahun->id)
            ->get();
            
        $ekstrakurikuler = EkstrakurikulerSiswa::where('siswa_id', $siswa_id)
            ->where('tahun_akademik_id', $tahun->id)
            ->get();

        return view('walikelas.rapor.edit', compact('siswa', 'tahun', 'catatan', 'ketidakhadiran', 'prestasi', 'ekstrakurikuler'));
    }

    public function update(Request $request, $siswa_id)
    {
        $request->validate([
            'catatan_walikelas' => 'nullable|string',
            'sakit' => 'required|integer|min:0',
            'izin' => 'required|integer|min:0',
            'tanpa_keterangan' => 'required|integer|min:0',
            'prestasi.*.jenis_prestasi' => 'nullable|string|max:255',
            'prestasi.*.keterangan' => 'nullable|string',
            'ekskul.*.nama_ekskul' => 'nullable|string|max:255',
            'ekskul.*.nilai' => 'nullable|string|max:5',
            'ekskul.*.keterangan' => 'nullable|string',
        ]);

        $siswa = Siswa::findOrFail($siswa_id);
        $tahun = TahunAkademik::where('is_active', 1)->first();

        // Update Catatan Wali Kelas
        CatatanWalikelas::updateOrCreate(
            ['siswa_id' => $siswa->id, 'tahun_akademik_id' => $tahun->id],
            ['catatan' => $request->catatan_walikelas]
        );

        // Update Ketidakhadiran
        Ketidakhadiran::updateOrCreate(
            ['siswa_id' => $siswa->id, 'tahun_akademik_id' => $tahun->id],
            [
                'sakit' => $request->sakit,
                'izin' => $request->izin,
                'tanpa_keterangan' => $request->tanpa_keterangan,
            ]
        );

        // Update Prestasi (Hapus dan buat baru)
        Prestasi::where('siswa_id', $siswa->id)->where('tahun_akademik_id', $tahun->id)->delete();
        if ($request->has('prestasi')) {
            foreach ($request->prestasi as $p) {
                if (!empty($p['jenis_prestasi'])) {
                    Prestasi::create([
                        'siswa_id' => $siswa->id,
                        'tahun_akademik_id' => $tahun->id,
                        'jenis_prestasi' => $p['jenis_prestasi'],
                        'keterangan' => $p['keterangan'],
                    ]);
                }
            }
        }

        // Update Ekstrakurikuler (Hapus dan buat baru)
        EkstrakurikulerSiswa::where('siswa_id', $siswa->id)->where('tahun_akademik_id', $tahun->id)->delete();
        if ($request->has('ekskul')) {
            foreach ($request->ekskul as $eks) {
                if (!empty($eks['nama_ekskul'])) {
                    EkstrakurikulerSiswa::create([
                        'siswa_id' => $siswa->id,
                        'tahun_akademik_id' => $tahun->id,
                        'nama_ekskul' => $eks['nama_ekskul'],
                        'nilai' => $eks['nilai'],
                        'keterangan' => $eks['keterangan'],
                    ]);
                }
            }
        }

        return redirect('rapor')->with('success', 'Data rapor berhasil diperbarui.');
    }
}
