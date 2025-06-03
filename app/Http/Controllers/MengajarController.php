<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mengajar;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\TahunAkademik;

class MengajarController extends Controller
{
    public function index()
    {
        $data = Mengajar::with(['guru', 'mapel', 'kelas', 'tahunAkademik'])->get();
        return view('admin.mengajar.index', compact('data'));
    }

    public function create()
    {
        $guru = Guru::all();
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        $tahun = TahunAkademik::where('is_active', 1)->first();

        return view('admin.mengajar.create', compact('guru', 'kelas', 'mapel', 'tahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required',
            'mapel_id' => 'required',
            'kelas_id' => 'required',
            'tahun_akademik_id' => 'required',
        ]);

        Mengajar::create($request->all());

        return redirect()->route('mengajar.index')->with('success', 'Data pengampu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $mengajar = Mengajar::findOrFail($id);
        $guru = Guru::all();
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        $tahun = TahunAkademik::where('is_active', 1)->first();

        return view('admin.mengajar.edit', compact('mengajar', 'guru', 'kelas', 'mapel', 'tahun'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'guru_id' => 'required',
            'mapel_id' => 'required',
            'kelas_id' => 'required',
            'tahun_akademik_id' => 'required',
        ]);

        $mengajar = Mengajar::findOrFail($id);
        $mengajar->update($request->all());

        return redirect()->route('mengajar.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        Mengajar::destroy($id);
        return redirect()->route('mengajar.index')->with('success', 'Data berhasil dihapus');
    }
}
