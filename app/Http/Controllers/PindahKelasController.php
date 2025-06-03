<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAkademik;

class PindahKelasController extends Controller
{
    public function index()
    {
        $data = KelasSiswa::with(['siswa', 'kelas', 'tahunAkademik'])->get();
        return view('admin.rombongan.index', compact('data'));
    }

    public function create()
    {
        $siswa = Siswa::all();
        $kelas = Kelas::all();
        $tahun = TahunAkademik::where('is_active', 1)->first();

        return view('admin.rombongan.create', compact('siswa', 'kelas', 'tahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'kelas_id' => 'required',
            'tahun_akademik_id' => 'required',
        ]);

        // Cek jika siswa sudah ditempatkan di tahun tersebut
        $existing = KelasSiswa::where('siswa_id', $request->siswa_id)
                              ->where('tahun_akademik_id', $request->tahun_akademik_id)
                              ->first();

        if ($existing) {
            return back()->with('error', 'Siswa sudah ditempatkan di tahun akademik ini.');
        }

        KelasSiswa::create($request->all());

        return redirect()->route('pindah-kelas.index')->with('success', 'Data berhasil disimpan');
    }

    public function destroy($id)
    {
        KelasSiswa::destroy($id);
        return redirect()->route('pindah-kelas.index')->with('success', 'Data dihapus');
    }
}
