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

        // Jika bukan admin dan tidak ada data guru
        if ($user->role !== 'admin' && !$guru) {
            return back()->with('error', 'Data guru tidak ditemukan. Silahkan hubungi admin untuk menghubungkan akun Anda dengan data guru.');
        }

        // Ambil data jadwal mengajar
        $jadwal = Mengajar::with(['kelas', 'mapel', 'guru']);
        
        // Jika bukan admin, filter berdasarkan guru
        if ($user->role !== 'admin') {
            $jadwal = $jadwal->where('guru_id', $guru->id);
        }
        
        $jadwal = $jadwal->get();

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

        // Tentukan view berdasarkan role
        $view = $user->role === 'admin' ? 'admin.nilai.index' : 'guru.nilai.index';

        return view($view, compact('jadwal'));
    }

    public function show($jadwal_id)
    {
        $user = auth()->user();
        $guru = $user->guru;

        // Jika user adalah admin, tidak perlu cek guru
        if ($user->role !== 'admin' && !$guru) {
            return back()->with('error', 'Data guru tidak ditemukan.');
        }

        $jadwal = Mengajar::with(['kelas', 'mapel'])
            ->where('id', $jadwal_id);
            
        // Jika bukan admin, pastikan jadwal milik guru ini
        if ($user->role !== 'admin') {
            $jadwal = $jadwal->where('guru_id', $guru->id);
        }
        
        $jadwal = $jadwal->firstOrFail();

        $kelas_id = $jadwal->kelas_id;
        $mapel_id = $jadwal->mapel_id;
        $guru_id = $jadwal->guru_id;
        $tahun_id = $jadwal->tahun_akademik_id;

        $siswa = KelasSiswa::where('kelas_id', $kelas_id)
                  ->with('siswa')
                  ->get();

        // Ambil data nilai yang sudah ada
        $nilai_siswa = NilaiSiswa::where('mapel_id', $mapel_id)
                        ->where('kelas_id', $kelas_id)
                        ->where('guru_id', $guru_id)
                        ->where('tahun_akademik_id', $tahun_id)
                        ->get()
                        ->keyBy('siswa_id');

        // Tentukan view berdasarkan role
        $view = $user->role === 'admin' ? 'admin.nilai.input' : 'guru.nilai.input';

        return view($view, compact('jadwal', 'siswa', 'mapel_id', 'guru_id', 'tahun_id', 'kelas_id', 'nilai_siswa'));
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
