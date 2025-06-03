<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WaliKelas;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\TahunAkademik;

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

        WaliKelas::create($request->all());

        return redirect()->route('wali-kelas.index')->with('success', 'Wali kelas ditetapkan.');
    }

    public function destroy($id)
    {
        WaliKelas::destroy($id);
        return redirect()->route('wali-kelas.index')->with('success', 'Data dihapus.');
    }
}
