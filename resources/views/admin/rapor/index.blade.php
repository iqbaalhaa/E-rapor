@extends('layouts.main')
@section('title', 'Cetak Rapor')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Pilih Kelas</h4>

    <form method="GET">
      <div class="form-group">
        <label for="kelas_id">Kelas</label>
        <select name="kelas_id" class="form-control" onchange="this.form.submit()">
          <option value="">-- Pilih Kelas --</option>
          @foreach($kelas as $k)
            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
              {{ $k->nama_kelas }}
            </option>
          @endforeach
        </select>
      </div>
    </form>

    @if(request('kelas_id'))
      <a href="{{ route('admin.rapor.kelas', request('kelas_id')) }}" class="btn btn-primary mb-3" target="_blank">
        Cetak Semua Rapor Kelas
      </a>

      @php
        $siswa = \App\Models\KelasSiswa::where('kelas_id', request('kelas_id'))
                  ->where('tahun_akademik_id', $tahun->id)
                  ->with('siswa')->get();
      @endphp

      <h5 class="mt-4">Daftar Siswa</h5>
      <table class="table">
        <thead>
          <tr><th>Nama</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          @foreach($siswa as $s)
            <tr>
              <td>{{ $s->siswa->nama }}</td>
              <td><a href="{{ route('admin.rapor.show', $s->siswa->id) }}" class="btn btn-success btn-sm" target="_blank">Cetak</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

  </div>
</div>
@endsection
