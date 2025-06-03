<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAkademik;
use App\Models\KelasSiswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['kelasSiswa.kelas', 'kelasSiswa.tahunAkademik'])->get();
        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $tahun = TahunAkademik::where('is_active', 1)->first(); // ambil tahun aktif
        return view('admin.siswa.create', compact('kelas', 'tahun'));
    }

    public function store(Request $request)
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

            // 1. Simpan data siswa
            $siswa = Siswa::create([
                'nama' => $request->nama,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
            ]);

            // 2. Simpan relasi kelas
            KelasSiswa::create([
                'siswa_id' => $siswa->id,
                'kelas_id' => $request->kelas_id,
                'tahun_akademik_id' => $request->tahun_akademik_id,
            ]);

            \DB::commit();
            return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::all();
        $tahun = TahunAkademik::where('is_active', 1)->first();
        $relasi = KelasSiswa::where('siswa_id', $id)->where('tahun_akademik_id', $tahun->id)->first();

        return view('admin.siswa.edit', compact('siswa', 'kelas', 'tahun', 'relasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nis' => 'required|unique:siswa,nis,' . $id,
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required',
            'tahun_akademik_id' => 'required',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->only([
            'nama', 'nis', 'nisn', 'email', 'jenis_kelamin', 'no_hp'
        ]));

        // Update atau insert ke kelas_siswa
        KelasSiswa::updateOrCreate(
            [
                'siswa_id' => $id,
                'tahun_akademik_id' => $request->tahun_akademik_id,
            ],
            [
                'kelas_id' => $request->kelas_id,
            ]
        );

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        KelasSiswa::where('siswa_id', $id)->delete(); // hapus relasi kelas
        Siswa::destroy($id);
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus');
    }
}
