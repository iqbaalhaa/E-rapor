<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('admin.kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
        ]);
    
        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
        ]);
    
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required',
        ]);
    
        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
        ]);
    
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui');
    }    

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.edit', compact('kelas'));
    }

    public function destroy($id)
    {
        Kelas::destroy($id);
        return redirect()->route('kelas.index')->with('success', 'Kelas dihapus');
    }
}
