<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;

class MapelController extends Controller
{
    public function index()
    {
        $mapel = Mapel::all();
        return view('admin.mapel.index', compact('mapel'));
    }

    public function create()
    {
        return view('admin.mapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:mapel',
            'nama' => 'required',
            'jenis' => 'required',
            'kkm' => 'required|numeric',
        ]);

        Mapel::create($request->all());

        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran ditambahkan');
    }

    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);
        return view('admin.mapel.edit', compact('mapel'));
    }

    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);

        $request->validate([
            'kode' => 'required|unique:mapel,kode,' . $id,
            'nama' => 'required',
            'jenis' => 'required',
            'kkm' => 'required|numeric',
        ]);

        $mapel->update($request->all());

        return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran diperbarui');
    }

    public function destroy($id)
    {
        Mapel::destroy($id);
        return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran dihapus');
    }
}
