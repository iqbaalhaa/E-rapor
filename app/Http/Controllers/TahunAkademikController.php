<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAkademik;

class TahunAkademikController extends Controller
{
    public function index()
    {
        $tahunAkademik = TahunAkademik::orderBy('tahun', 'desc')->get();
        return view('admin.tahun_akademik.index', compact('tahunAkademik'));
    }

    public function create()
    {
        return view('admin.tahun_akademik.create');
    }

    public function store(Request $request)
    {
        TahunAkademik::create($request->all());
        return redirect()->route('tahun-akademik.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $tahunAkademik = TahunAkademik::findOrFail($id);
        return view('admin.tahun_akademik.edit', compact('tahunAkademik'));
    }

    public function update(Request $request, $id)
    {
        $tahunAkademik = TahunAkademik::findOrFail($id);
        $tahunAkademik->update($request->all());
        return redirect()->route('tahun-akademik.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        TahunAkademik::destroy($id);
        return redirect()->route('tahun-akademik.index')->with('success', 'Data berhasil dihapus');
    }

}
