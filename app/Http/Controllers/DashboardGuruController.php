<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mengajar;
use Illuminate\Support\Facades\Auth;

class DashboardGuruController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        
        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }

        $jadwal = Mengajar::with(['kelas', 'mapel', 'tahunAkademik'])
            ->where('guru_id', $guru->id)
            ->get();

        return view('guru.dashboard', compact('jadwal'));
    }
}
