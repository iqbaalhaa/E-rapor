<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::all();
        return view('admin.guru.index', compact('guru'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|unique:guru,nip',
        ]);

        // 1. Buat akun user
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make('password123'), // password default
            'role' => 'guru',
        ]);

        // 2. Simpan guru dan hubungkan ke user
        $guru = Guru::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'user_id' => $user->id,
        ]);

        // 3. Update linked_id di user
        $user->update(['linked_id' => $guru->id]);

        return redirect()->route('guru.index')->with('success', 'Data guru & akun berhasil dibuat.');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->update($request->all());
        return redirect()->route('guru.index')->with('success', 'Data guru diupdate');
    }

    public function destroy($id)
    {
        Guru::destroy($id);
        return back()->with('success', 'Guru dihapus');
    }
}
