<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Guru;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $guru = null;
        
        // Jika user adalah guru, ambil data guru
        if ($user->role === 'guru' || $user->role === 'walikelas') {
            $guru = Guru::where('user_id', $user->id)->first();
            
            // Jika belum ada data guru, buat data kosong untuk form
            if (!$guru) {
                $guru = new Guru();
                $guru->nama = $user->name;
                $guru->email = $user->email;
                $guru->nip = '';
            }
        }
        
        return view('profile.edit', compact('user', 'guru'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nip' => 'nullable|string|max:20',
        ]);

        // Validasi NIP jika diisi
        if ($request->filled('nip')) {
            if (!preg_match('/^[0-9]+$/', $request->nip)) {
                return back()->withErrors(['nip' => 'NIP hanya boleh berisi angka']);
            }
        }

        // Update data user
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Update password jika diisi
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
            }
            $userData['password'] = Hash::make($request->new_password);
        }

        // Upload foto jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists('profile-photos/' . $user->photo)) {
                Storage::disk('public')->delete('profile-photos/' . $user->photo);
            }
            
            $photo = $request->file('photo');
            $photoName = time() . '_' . $user->id . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('profile-photos', $photoName, 'public');
            $userData['photo'] = $photoName;
        }

        $user->update($userData);

        // Update data guru jika user adalah guru
        if ($user->role === 'guru' || $user->role === 'walikelas') {
            $guru = Guru::where('user_id', $user->id)->first();
            
            if ($request->filled('nip')) {
                if ($guru) {
                    // Validasi NIP unik kecuali untuk guru ini sendiri
                    if ($request->nip !== $guru->nip) {
                        $existingGuru = Guru::where('nip', $request->nip)->where('id', '!=', $guru->id)->first();
                        if ($existingGuru) {
                            return back()->withErrors(['nip' => 'NIP sudah digunakan oleh guru lain']);
                        }
                    }
                    
                    $guru->update([
                        'nama' => $request->name,
                        'nip' => $request->nip,
                        'email' => $request->email,
                    ]);
                } else {
                    // Jika data guru belum ada, buat baru
                    $existingGuru = Guru::where('nip', $request->nip)->first();
                    if ($existingGuru) {
                        return back()->withErrors(['nip' => 'NIP sudah digunakan oleh guru lain']);
                    }
                    
                    Guru::create([
                        'nama' => $request->name,
                        'nip' => $request->nip,
                        'email' => $request->email,
                        'user_id' => $user->id,
                    ]);
                }
            } else if ($guru) {
                // Update nama dan email saja jika NIP kosong
                $guru->update([
                    'nama' => $request->name,
                    'email' => $request->email,
                ]);
            } else {
                // Jika belum ada data guru dan NIP kosong, buat data guru tanpa NIP
                Guru::create([
                    'nama' => $request->name,
                    'nip' => null,
                    'email' => $request->email,
                    'user_id' => $user->id,
                ]);
            }
        }

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui');
    }
} 