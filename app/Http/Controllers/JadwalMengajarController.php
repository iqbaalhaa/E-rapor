<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMengajar;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\WaliKelas;
use App\Models\TahunAkademik;

class JadwalMengajarController extends Controller
{
    public function index()
    {
        $tahun = TahunAkademik::where('is_active', 1)->first();
        $guru_id = auth()->user()->guru->id;

        $wali = WaliKelas::where('guru_id', $guru_id)
                ->where('tahun_akademik_id', $tahun->id)
                ->first();

        $jadwal = JadwalMengajar::with(['guru', 'mapel'])
                    ->where('kelas_id', $wali->kelas_id)
                    ->where('tahun_akademik_id', $tahun->id)
                    ->get();

        return view('walikelas.jadwal.index', compact('jadwal', 'wali'));
    }

    public function create()
    {
        $mapel = Mapel::all();
        $guru = Guru::all();
        return view('walikelas.jadwal.create', compact('mapel', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required',
            'mapel_id' => 'required',
        ]);

        $tahun = TahunAkademik::where('is_active', 1)->first();
        $wali = WaliKelas::where('guru_id', auth()->user()->guru->id)
                        ->where('tahun_akademik_id', $tahun->id)->first();

        JadwalMengajar::create([
            'guru_id' => $request->guru_id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $wali->kelas_id,
            'tahun_akademik_id' => $tahun->id,
        ]);

        return redirect()->route('jadwal-mengajar.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function destroy($id)
    {
        JadwalMengajar::destroy($id);
        return back()->with('success', 'Jadwal dihapus');
    }
}
