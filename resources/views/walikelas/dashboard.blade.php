@extends('layouts.main')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Dashboard Wali Kelas</h4>

    @if(isset($error) && $error)
      <div class="alert alert-warning">{{ $error }}</div>
    @elseif(!isset($wali) || !isset($tahun) || !isset($jumlah_siswa) || !isset($jadwal_mengajar))
      <div class="alert alert-warning">Data tidak lengkap. Silahkan hubungi admin.</div>
    @else
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Informasi Wali Kelas</h5>
              <p><strong>Wali Kelas:</strong> {{ auth()->user()->guru->nama }}</p>
              <p><strong>Kelas:</strong> {{ $wali->kelas->nama_kelas }}</p>
              <p><strong>Tahun Akademik:</strong> {{ $tahun->tahun }}</p>
              <p><strong>Jumlah Siswa:</strong> {{ $jumlah_siswa }}</p>

              <div class="mt-3">
                <a href="{{ route('nilai-guru.index') }}" class="btn btn-info">Lihat Nilai dari Guru</a>
                <a href="{{ route('jadwal-mengajar.index') }}" class="btn btn-warning">Atur Guru Mapel</a>
                <a href="{{ route('rapor.index') }}" class="btn btn-success">Cetak Raport</a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Jadwal Mengajar</h5>
              @if($jadwal_mengajar->isEmpty())
                <div class="alert alert-info">Belum ada jadwal mengajar</div>
              @else
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($jadwal_mengajar as $jadwal)
                      <tr>
                        <td>{{ $jadwal->kelas->nama_kelas }}</td>
                        <td>{{ $jadwal->mapel->nama }}</td>
                        <td>
                          <a href="{{ route('input-nilai.show', $jadwal->id) }}" class="btn btn-primary btn-sm">
                            Input Nilai
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
    @endif
  </div>
</div>
@endsection
