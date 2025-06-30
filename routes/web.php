<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TahunAkademikController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MengajarController;
use App\Http\Controllers\PindahKelasController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\InputNilaiController;
use App\Http\Controllers\JadwalMengajarController;
use App\Http\Controllers\NilaiGuruController;
use App\Http\Controllers\CetakRaporController;
use App\Http\Controllers\Admin\CetakRaporController as AdminCetakRaporController;
use App\Http\Controllers\Walikelas\InputRaporController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', function () {
    return redirect('/dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;

        return match ($role) {
            'admin' => view('admin.dashboard'),
            'guru' => view('guru.dashboard'),
            'walikelas' => view('walikelas.dashboard'),
            default => abort(403, 'Role tidak dikenali'),
        };
    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('tahun-akademik', TahunAkademikController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('mapel', MapelController::class);
    Route::resource('kelas', KelasController::class);
    Route::put('kelas/{kela}', [KelasController::class, 'update'])->name('kelas.update');
    Route::resource('user', UserController::class);
    Route::resource('mengajar', MengajarController::class);
    Route::resource('pindah-kelas', PindahKelasController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('wali-kelas', WaliKelasController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('admin/rapor', [AdminCetakRaporController::class, 'index'])->name('admin.rapor.index');
    Route::get('admin/rapor/{siswa}', [AdminCetakRaporController::class, 'show'])->name('admin.rapor.show');
    Route::get('admin/rapor-kelas/{kelas_id}', [AdminCetakRaporController::class, 'cetakKelas'])->name('admin.rapor.kelas');
});


//--- GURU & WALI KELAS ---//
Route::middleware(['auth', 'role:guru|walikelas'])->group(function () {
    Route::get('input-nilai', [InputNilaiController::class, 'index'])->name('input-nilai.index');
    Route::get('input-nilai/{id}', [InputNilaiController::class, 'show'])->name('input-nilai.show');
    Route::post('input-nilai', [InputNilaiController::class, 'store'])->name('input-nilai.store');
    Route::get('nilai', [InputRaporController::class, 'index'])->name('nilai.index');
    Route::post('nilai/store', [InputRaporController::class, 'store'])->name('nilai.store');
});


//--- WALI KELAS ---//
Route::middleware(['auth', 'role:walikelas'])->group(function () {
    Route::get('/dashboard/walikelas', function() { return view('walikelas.dashboard'); })->name('walikelas.dashboard');

    // CRUD Siswa oleh Wali Kelas
    Route::get('walikelas/siswa', [WaliKelasController::class, 'indexSiswa'])->name('walikelas.siswa.index');
    Route::get('walikelas/siswa/create', [WaliKelasController::class, 'createSiswa'])->name('walikelas.siswa.create');
    Route::post('walikelas/siswa', [WaliKelasController::class, 'storeSiswa'])->name('walikelas.siswa.store');

    Route::resource('jadwal-mengajar', JadwalMengajarController::class);

    Route::get('nilai-guru', [NilaiGuruController::class, 'index'])->name('nilai-guru.index');
    Route::get('nilai-guru/{siswa}', [NilaiGuruController::class, 'edit'])->name('nilai-guru.edit');
    Route::put('nilai-guru/{siswa}', [NilaiGuruController::class, 'update'])->name('nilai-guru.update');

    Route::get('rapor', [CetakRaporController::class, 'index'])->name('rapor.index');
    Route::get('rapor/{siswa_id}', [CetakRaporController::class, 'show'])->name('rapor.show');

    // Route untuk input data rapor
    Route::get('rapor/{siswa_id}/edit', [InputRaporController::class, 'edit'])->name('rapor.edit');
    Route::post('rapor/{siswa_id}/update', [InputRaporController::class, 'update'])->name('rapor.update');
});

