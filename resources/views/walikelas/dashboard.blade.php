@extends('layouts.main')

@section('title', 'Dashboard Wali Kelas')

@php
    $error = null;
    $user = Auth::user();
    $guru = $user->guru;

    if (!$guru) {
        $error = 'Data guru tidak ditemukan. Silahkan hubungi admin.';
    }

    $tahun = null;
    if (!$error) {
        $tahun = \App\Models\TahunAkademik::where('is_active', 1)->first();
        if (!$tahun) {
            $error = 'Tidak ada tahun akademik yang aktif.';
        }
    }

    $wali = null;
    if (!$error) {
        $wali = \App\Models\WaliKelas::where('guru_id', $guru->id)
            ->where('tahun_akademik_id', $tahun->id)
            ->with(['guru', 'kelas'])->first();
        if (!$wali) {
            $error = 'Anda belum ditugaskan sebagai wali kelas untuk tahun akademik ini.';
        }
    }
    
    if(!$error) {
        $kelas_id = $wali->kelas_id;
        $siswa_kelas = \App\Models\KelasSiswa::where('kelas_id', $kelas_id)->where('tahun_akademik_id', $tahun->id)->get();
        $jumlah_siswa = $siswa_kelas->count();

        $jadwal_mengajar = \App\Models\Mengajar::with(['mapel', 'guru'])
            ->where('kelas_id', $kelas_id)
            ->where('tahun_akademik_id', $tahun->id)
            ->get();
            
        $total_nilai_seharusnya = $jumlah_siswa * $jadwal_mengajar->count();
        $total_nilai_terinput = \App\Models\NilaiSiswa::where('kelas_id', $kelas_id)
                                        ->where('tahun_akademik_id', $tahun->id)
                                        ->count();
        
        $rekap_nilai = [
            'total_nilai' => $total_nilai_seharusnya,
            'sudah_dinilai' => $total_nilai_terinput,
        ];
        
        // Placeholder untuk rekap rapor
        $rekap_rapor = [
            'sudah_cetak' => 0,
        ];

        $progress_mapel = [];
        foreach ($jadwal_mengajar as $jadwal) {
            if ($jadwal->guru && $jadwal->mapel) {
                $nilai_mapel_terinput = \App\Models\NilaiSiswa::where('kelas_id', $kelas_id)
                                                ->where('mapel_id', $jadwal->mapel_id)
                                                ->where('tahun_akademik_id', $tahun->id)
                                                ->count();
                
                $persen = $jumlah_siswa > 0 ? ($nilai_mapel_terinput / $jumlah_siswa) * 100 : 0;
                $status = ($nilai_mapel_terinput == $jumlah_siswa) ? 'Lengkap' : 'Belum';
                
                $progress_mapel[] = [
                    'nama_mapel' => $jadwal->mapel->nama,
                    'nama_guru' => $jadwal->guru->nama,
                    'status' => $status,
                    'badge_class' => $status == 'Lengkap' ? 'badge-success' : 'badge-warning',
                    'persen' => $persen,
                    'progress_class' => $persen < 50 ? 'bg-danger' : ($persen < 100 ? 'bg-warning' : 'bg-success'),
                ];
            }
        }
    } 
@endphp

@push('styles')
<style>
  .icon-box {
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
  }
  .icon-box-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
  .icon-box-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
  .icon-box-success { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }

  .card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
    border-radius: 10px;
  }
  .progress { height: 10px; border-radius: 5px; }
  .progress-bar { border-radius: 5px; }
  .table-hover tbody tr:hover { background-color: rgba(0,123,255,0.05); }
  .badge { padding: 0.5em 0.75em; font-size: 0.75em; }
  .btn-block { transition: all 0.3s ease; }
  .btn-block:hover { transform: translateY(-2px); }
</style>
@endpush

@section('content')
@if($error)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                <i class="ti-alert text-warning" style="font-size: 4rem;"></i>
                <h4 class="mt-3">Akses Ditolak</h4>
                <p class="text-muted">{{ $error }}</p>
            </div>
        </div>
    </div>
</div>
@else
<!-- Header Welcome -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="mr-3">
                        <i class="ti-user text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <div>
                        <h4 class="card-title mb-1">Selamat Datang, {{ $wali->guru->nama }}</h4>
                        <p class="text-muted mb-0">
                            Wali Kelas: <strong>{{ $wali->kelas->nama_kelas }}</strong> - 
                            T.A {{ $tahun->tahun }} {{ $tahun->semester }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<!-- Statistik Cards -->
<div class="row">
    <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <h3 class="mb-0">{{ $jumlah_siswa }}</h3>
                        <h6 class="text-muted font-weight-normal">Total Siswa</h6>
                    </div>
                    <div class="col-3">
                        <div class="icon-box icon-box-primary"><span class="ti-user"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <h3 class="mb-0">{{ $rekap_nilai['sudah_dinilai'] }}/{{ $rekap_nilai['total_nilai'] }}</h3>
                        <h6 class="text-muted font-weight-normal">Nilai Terinput</h6>
                    </div>
                    <div class="col-3">
                        <div class="icon-box icon-box-info"><span class="ti-check-box"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <h3 class="mb-0">{{ $rekap_rapor['sudah_cetak'] }}/{{ $jumlah_siswa }}</h3>
                        <h6 class="text-muted font-weight-normal">Rapor Tercetak</h6>
                    </div>
                    <div class="col-3">
                        <div class="icon-box icon-box-success"><span class="ti-printer"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Progress Nilai -->
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Progress Input Nilai Seluruh Mapel</h4>
                @php
                    $persentase = $rekap_nilai['total_nilai'] > 0 ? ($rekap_nilai['sudah_dinilai'] / $rekap_nilai['total_nilai']) * 100 : 0;
                @endphp
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $persentase }}%" aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($persentase, 1) }}%</div>
                </div>
                <small class="text-muted mt-2 d-block">
                    {{ $rekap_nilai['sudah_dinilai'] }} dari {{ $rekap_nilai['total_nilai'] }} total entri nilai telah diisi oleh guru mata pelajaran.
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Progress Nilai per Mapel -->
<div class="row">
    <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Progress Nilai per Mata Pelajaran</h4>
                @if($jadwal_mengajar->isEmpty())
                    <div class="alert alert-info"><i class="ti-info-alt"></i> Belum ada jadwal mengajar yang diatur untuk kelas ini.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th>Guru</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($progress_mapel as $mapel)
                                <tr>
                                    <td><strong>{{ $mapel['nama_mapel'] }}</strong></td>
                                    <td>{{ $mapel['nama_guru'] }}</td>
                                    <td>
                                        <span class="badge {{ $mapel['badge_class'] }}">{{ $mapel['status'] }}</span>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar {{ $mapel['progress_class'] }}" role="progressbar" style="width: {{ $mapel['persen'] }}%" aria-valuenow="{{ $mapel['persen'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Aksi Cepat</h4>
                <div class="list-group list-group-flush">
                    <a href="{{ route('walikelas.nilai.index') }}" class="list-group-item list-group-item-action">
                        <i class="ti-medall-alt menu-icon"></i> Lihat Rekap Nilai Siswa
                    </a>
                    <a href="{{ route('walikelas.rapor.index') }}" class="list-group-item list-group-item-action">
                        <i class="ti-layout-list-thumb menu-icon"></i> Proses & Cetak Rapor
                    </a>
                    <a href="{{ route('walikelas.jadwal.index') }}" class="list-group-item list-group-item-action">
                       <i class="ti-calendar menu-icon"></i> Lihat Jadwal Mapel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
