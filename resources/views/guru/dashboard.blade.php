@extends('layouts.main')

@section('title', 'Dashboard Guru')

@push('styles')
<style>
  .icon-box-success {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  }
  .icon-box-primary {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  }
  .icon-box-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
  }
  .icon-box-warning {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
  }
  .icon-box-success, .icon-box-primary, .icon-box-info, .icon-box-warning {
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .icon-item {
    color: white;
    font-size: 1.5rem;
  }
  .card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
    border-radius: 10px;
  }
  .progress {
    height: 10px;
    border-radius: 5px;
  }
  .progress-bar {
    border-radius: 5px;
  }
  .table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
  }
  .badge {
    padding: 0.5em 0.75em;
    font-size: 0.75em;
  }
  .btn-outline-primary:hover, .btn-outline-info:hover, .btn-outline-success:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
  }
</style>
@endpush

@section('content')
@php
  $user = Auth::user();
  $guru = $user->guru;
  $tahun_aktif = \App\Models\TahunAkademik::where('is_active', 1)->first();
  
  if ($guru && $tahun_aktif) {
    $jadwal = \App\Models\Mengajar::with(['kelas', 'mapel', 'tahunAkademik'])
      ->where('guru_id', $guru->id)
      ->where('tahun_akademik_id', $tahun_aktif->id)
      ->get();
    
    $total_kelas = $jadwal->count();
    $total_mapel = $jadwal->unique('mapel_id')->count();
    
    $total_siswa = 0;
    $nilai_sudah_input = 0;
    $nilai_belum_input = 0;
    
    foreach ($jadwal as $j) {
      $jumlah_siswa_kelas = \App\Models\KelasSiswa::where('kelas_id', $j->kelas_id)
        ->where('tahun_akademik_id', $tahun_aktif->id)
        ->count();
      $total_siswa += $jumlah_siswa_kelas;
      
      $nilai_terinput = \App\Models\NilaiSiswa::where('mapel_id', $j->mapel_id)
        ->where('kelas_id', $j->kelas_id)
        ->where('guru_id', $guru->id)
        ->where('tahun_akademik_id', $tahun_aktif->id)
        ->count();
      
      $nilai_sudah_input += $nilai_terinput;
      $nilai_belum_input += ($jumlah_siswa_kelas - $nilai_terinput);
    }
  } else {
    $jadwal = collect();
    $total_kelas = 0;
    $total_mapel = 0;
    $total_siswa = 0;
    $nilai_sudah_input = 0;
    $nilai_belum_input = 0;
  }
@endphp

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
            <h4 class="card-title mb-1">Selamat Datang, {{ $user->name }}</h4>
            <p class="text-muted mb-0">Dashboard Guru - {{ $tahun_aktif ? $tahun_aktif->tahun . ' ' . $tahun_aktif->semester : 'Tahun Akademik Belum Aktif' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<br>


@if(!$guru)
<!-- Pesan jika tidak ada data guru -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body text-center">
        <i class="ti-alert text-warning" style="font-size: 4rem;"></i>
        <h4 class="mt-3">Data Guru Tidak Ditemukan</h4>
        <p class="text-muted">Silahkan hubungi admin untuk menghubungkan akun Anda dengan data guru.</p>
      </div>
    </div>
  </div>
</div>

@elseif(!$tahun_aktif)
<!-- Pesan jika tidak ada tahun akademik aktif -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body text-center">
        <i class="ti-alert text-warning" style="font-size: 4rem;"></i>
        <h4 class="mt-3">Tahun Akademik Belum Aktif</h4>
        <p class="text-muted">Silahkan hubungi admin untuk mengaktifkan tahun akademik.</p>
      </div>
    </div>
  </div>
</div>

@else
<!-- Statistik Cards -->
<div class="row">
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">{{ $total_kelas }}</h3>
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-success">
              <span class="ti-home icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">Total Kelas</h6>
      </div>
    </div>
  </div>
  
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">{{ $total_mapel }}</h3>
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-primary">
              <span class="ti-book icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">Mata Pelajaran</h6>
      </div>
    </div>
  </div>
  
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">{{ $total_siswa }}</h3>
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-info">
              <span class="ti-user icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">Total Siswa</h6>
      </div>
    </div>
  </div>
  
  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">{{ $nilai_sudah_input }}</h3>
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-warning">
              <span class="ti-check icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">Nilai Terinput</h6>
      </div>
    </div>
  </div>
</div>

<!-- Progress Nilai -->
<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Progress Input Nilai</h4>
        <div class="d-flex justify-content-between mb-2">
          <span>Nilai yang sudah diinput</span>
          <span>{{ $nilai_sudah_input }} / {{ $total_siswa }}</span>
        </div>
        <div class="progress">
          @php
            $persentase = $total_siswa > 0 ? ($nilai_sudah_input / $total_siswa) * 100 : 0;
          @endphp
          <div class="progress-bar bg-success" role="progressbar" style="width: {{ $persentase }}%" 
               aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100">
            {{ number_format($persentase, 1) }}%
          </div>
        </div>
        <small class="text-muted mt-2 d-block">
          @if($nilai_belum_input > 0)
            Masih ada {{ $nilai_belum_input }} nilai yang belum diinput
          @else
            Semua nilai sudah diinput! 🎉
          @endif
        </small>
      </div>
    </div>
  </div>
</div>

<!-- Daftar Jadwal Mengajar -->
<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Jadwal Mengajar</h4>
        
        @if($jadwal->isEmpty())
          <div class="alert alert-info">
            <i class="ti-info-alt"></i>
            Belum ada jadwal mengajar yang terdaftar untuk tahun akademik ini.
          </div>
        @else
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kelas</th>
                  <th>Mata Pelajaran</th>
                  <th>Status Nilai</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($jadwal as $index => $item)
                  @php
                    $jumlah_siswa = \App\Models\KelasSiswa::where('kelas_id', $item->kelas_id)
                        ->where('tahun_akademik_id', $tahun_aktif->id)
                        ->count();
                    $nilai_terinput = \App\Models\NilaiSiswa::where('mapel_id', $item->mapel_id)
                        ->where('kelas_id', $item->kelas_id)
                        ->where('guru_id', $guru->id)
                        ->where('tahun_akademik_id', $tahun_aktif->id)
                        ->count();
                    $status_nilai = $nilai_terinput == $jumlah_siswa ? 'Lengkap' : 'Belum Lengkap';
                    $badge_class = $nilai_terinput == $jumlah_siswa ? 'badge-success' : 'badge-warning';
                  @endphp
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                      <strong>{{ $item->kelas->nama_kelas }}</strong>
                      <br>
                      <small class="text-muted">{{ $jumlah_siswa }} siswa</small>
                    </td>
                    <td>
                      <strong>{{ $item->mapel->nama }}</strong>
                      <br>
                      <small class="text-muted">{{ $item->mapel->jenis ?? 'Mata Pelajaran' }}</small>
                    </td>
                    <td>
                      <span class="badge {{ $badge_class }}">
                        {{ $status_nilai }}
                      </span>
                      <br>
                      <small class="text-muted">{{ $nilai_terinput }}/{{ $jumlah_siswa }} nilai</small>
                    </td>
                    <td>
                      <a href="{{ route('input-nilai.show', $item->id) }}" class="btn btn-primary btn-sm">
                        <i class="ti-pencil"></i> Input Nilai
                      </a>
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
</div>

<!-- Quick Actions -->
<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Aksi Cepat</h4>
        <div class="row">
          <div class="col-md-4 mb-3">
            <a href="{{ route('input-nilai.index') }}" class="btn btn-outline-primary btn-block">
              <i class="ti-plus"></i>
              Input Nilai
            </a>
          </div>
          <div class="col-md-4 mb-3">
            <a href="#" class="btn btn-outline-info btn-block">
              <i class="ti-bar-chart"></i>
              Lihat Statistik
            </a>
          </div>
          <div class="col-md-4 mb-3">
            <a href="#" class="btn btn-outline-success btn-block">
              <i class="ti-download"></i>
              Export Data
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection
