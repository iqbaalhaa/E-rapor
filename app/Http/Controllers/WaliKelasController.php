<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WaliKelas;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\TahunAkademik;
use App\Models\User;
use App\Models\Siswa;
use App\Models\KelasSiswa;
use Illuminate\Support\Facades\Auth;

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

    public function indexSiswa()
    {
        $user = Auth::user();
        $waliKelas = WaliKelas::where('guru_id', $user->guru->id)->firstOrFail();
        $tahun = TahunAkademik::where('is_active', 1)->firstOrFail();

        $siswa = Siswa::whereHas('kelasSiswa', function ($query) use ($waliKelas, $tahun) {
            $query->where('kelas_id', $waliKelas->kelas_id)
                  ->where('tahun_akademik_id', $tahun->id);
        })->get();

        return view('walikelas.siswa.index', compact('siswa', 'waliKelas'));
    }

    public function createSiswa()
    {
        // 1. Dapatkan user yang sedang login
        $user = Auth::user();

        // 2. Dapatkan data wali kelas berdasarkan user_id
        $waliKelas = WaliKelas::where('guru_id', $user->guru->id)->first();
        
        // 3. Dapatkan tahun akademik yang aktif
        $tahun = TahunAkademik::where('is_active', 1)->first();

        // 4. Kirim data ke view
        return view('walikelas.siswa.create', [
            'waliKelas' => $waliKelas,
            'tahun' => $tahun,
        ]);
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nis' => 'required|unique:siswa',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required',
            'tahun_akademik_id' => 'required',
        ]);

        try {
            \DB::beginTransaction();

            $siswa = Siswa::create([
                'nama' => $request->nama,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
            ]);

            KelasSiswa::create([
                'siswa_id' => $siswa->id,
                'kelas_id' => $request->kelas_id,
                'tahun_akademik_id' => $request->tahun_akademik_id,
            ]);

            \DB::commit();
            // Redirect ke halaman daftar siswa untuk walikelas
            return redirect()->route('walikelas.siswa.index')->with('success', 'Siswa berhasil ditambahkan');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
