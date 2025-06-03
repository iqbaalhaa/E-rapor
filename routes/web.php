<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
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
use App\Http\Controllers\DashboardWaliKelasController;


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
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('guru', GuruController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('siswa', SiswaController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('mapel', MapelController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('kelas', KelasController::class);
    Route::put('kelas/{kela}', [KelasController::class, 'update'])->name('kelas.update');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('user', UserController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('mengajar', MengajarController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('pindah-kelas', PindahKelasController::class)->only(['index', 'create', 'store', 'destroy']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('wali-kelas', WaliKelasController::class)->only(['index', 'create', 'store', 'destroy']);
});



//Route Buat Guru 

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard/guru', [App\Http\Controllers\DashboardGuruController::class, 'index'])->name('dashboard.guru');
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('input-nilai', [InputNilaiController::class, 'index'])->name('input-nilai.index');
    Route::get('input-nilai/{id}', [InputNilaiController::class, 'show'])->name('input-nilai.show');
    Route::post('input-nilai', [InputNilaiController::class, 'store'])->name('input-nilai.store');
});



//Buat Walikelas

Route::middleware(['auth', 'role:walikelas'])->group(function () {
    Route::get('/dashboard/walikelas', [DashboardWaliKelasController::class, 'index'])->name('dashboard.walikelas');
});

Route::resource('/jadwal-mengajar', JadwalMengajar::class);
Route::resource('/nilai-guru', NilaiGuru::class);
Route::resource('/rapor', Rapor::class);
