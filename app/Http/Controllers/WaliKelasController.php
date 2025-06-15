<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WaliKelas;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\TahunAkademik;
use App\Models\User;

class WaliKelasController extends Controller
{
    public function index()
    {
        $data = WaliKelas::with(['guru', 'kelas', 'tahunAkademik'])->get();
        return view('admin.walikelas.index', compact('data'));
    }

    public function create()
    {
        $guru = Guru::all();
        $kelas = Kelas::all();
        $tahun = TahunAkademik::where('is_active', 1)->first();

        return view('admin.walikelas.create', compact('guru', 'kelas', 'tahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required',
            'kelas_id' => 'required',
            'tahun_akademik_id' => 'required',
        ]);

        // Cegah duplikat wali kelas
        $cek = WaliKelas::where('kelas_id', $request->kelas_id)
                        ->where('tahun_akademik_id', $request->tahun_akademik_id)
                        ->first();
        if ($cek) {
            return back()->with('error', 'Kelas ini sudah punya wali di tahun ini.');
        }

        // Buat data wali kelas
        WaliKelas::create($request->all());

        // Update role user menjadi walikelas
        $guru = Guru::find($request->guru_id);
        if ($guru && $guru->user) {
            $guru->user->update(['role' => 'walikelas']);
        }

        return redirect()->route('wali-kelas.index')->with('success', 'Wali kelas ditetapkan.');
    }

    public function destroy($id)
    {
        $waliKelas = WaliKelas::findOrFail($id);
        
        // Kembalikan role user menjadi guru
        $guru = Guru::find($waliKelas->guru_id);
        if ($guru && $guru->user) {
            $guru->user->update(['role' => 'guru']);
        }

        $waliKelas->delete();
        return redirect()->route('wali-kelas.index')->with('success', 'Data dihapus.');
    }
}
