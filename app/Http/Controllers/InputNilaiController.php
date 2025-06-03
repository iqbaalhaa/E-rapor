<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NilaiSiswa;
use App\Models\Mengajar;
use App\Models\KelasSiswa;

class InputNilaiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $guru = $user->guru;
        
        \Log::info('Data user dan guru:', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'role' => $user->role,
            'guru' => $guru
        ]);

        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan. Silahkan hubungi admin untuk menghubungkan akun Anda dengan data guru.');
        }

        // Debug data mapel
        $mapel = \App\Models\Mapel::find(3);
        \Log::info('Data mapel:', [
            'mapel' => $mapel ? $mapel->toArray() : 'null'
        ]);

        // Jika user adalah wali kelas, ambil data mengajar dari guru_id
        $jadwal = Mengajar::where('guru_id', $guru->id)
            ->with(['kelas', 'mapel'])
            ->get();

        \Log::info('Data jadwal detail:', [
            'count' => $jadwal->count(),
            'jadwal' => $jadwal->map(function($item) {
                return [
                    'id' => $item->id,
                    'kelas' => $item->kelas ? $item->kelas->nama_kelas : 'null',
                    'mapel' => $item->mapel ? $item->mapel->toArray() : 'null',
                    'kelas_id' => $item->kelas_id,
                    'mapel_id' => $item->mapel_id
                ];
            })->toArray()
        ]);

        return view('guru.nilai.index', compact('jadwal'));
    }

    public function show($jadwal_id)
    {
        $user = auth()->user();
        $guru = $user->guru;

        if (!$guru) {
            return back()->with('error', 'Data guru tidak ditemukan.');
        }

        $jadwal = Mengajar::with(['kelas', 'mapel'])
            ->where('id', $jadwal_id)
            ->where('guru_id', $guru->id) // Pastikan jadwal milik guru ini
            ->firstOrFail();

        $kelas_id = $jadwal->kelas_id;
        $mapel_id = $jadwal->mapel_id;
        $guru_id = $jadwal->guru_id;
        $tahun_id = $jadwal->tahun_akademik_id;

        $siswa = KelasSiswa::where('kelas_id', $kelas_id)
                  ->with('siswa')
                  ->get();

        return view('guru.nilai.input', compact('jadwal', 'siswa', 'mapel_id', 'guru_id', 'tahun_id', 'kelas_id'));
    }

    public function store(Request $request)
    {
        foreach ($request->nilai as $siswa_id => $nilai) {
            NilaiSiswa::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'mapel_id' => $request->mapel_id,
                    'kelas_id' => $request->kelas_id,
                    'guru_id' => $request->guru_id,
                    'tahun_akademik_id' => $request->tahun_akademik_id,
                ],
                [
                    'nilai_pengetahuan' => $nilai['pengetahuan'],
                    'nilai_keterampilan' => $nilai['keterampilan'],
                    'deskripsi' => $nilai['deskripsi'],
                ]
            );
        }

        return back()->with('success', 'Nilai berhasil disimpan.');
    }
}
