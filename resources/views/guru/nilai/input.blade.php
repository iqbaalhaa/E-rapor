@extends('layouts.main')

@section('title', 'Input Nilai')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Input Nilai {{ $jadwal->kelas->nama_kelas }} - {{ $jadwal->mapel->nama }}</h4>

    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('input-nilai.store') }}" method="POST">
      @csrf
      <input type="hidden" name="mapel_id" value="{{ $mapel_id }}">
      <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">
      <input type="hidden" name="guru_id" value="{{ $guru_id }}">
      <input type="hidden" name="tahun_akademik_id" value="{{ $tahun_id }}">

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nama Siswa</th>
            <th>Pengetahuan</th>
            <th>Keterampilan</th>
            <th>Deskripsi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($siswa as $row)
          <tr>
            <td>{{ $row->siswa->nama }}</td>
            <td>
              <input type="number" 
                     name="nilai[{{ $row->siswa->id }}][pengetahuan]" 
                     class="form-control" 
                     value="{{ $nilai_siswa->get($row->siswa->id)->nilai_pengetahuan ?? '' }}" 
                     required>
            </td>
            <td>
              <input type="number" 
                     name="nilai[{{ $row->siswa->id }}][keterampilan]" 
                     class="form-control" 
                     value="{{ $nilai_siswa->get($row->siswa->id)->nilai_keterampilan ?? '' }}" 
                     required>
            </td>
            <td>
              <input type="text" 
                     name="nilai[{{ $row->siswa->id }}][deskripsi]" 
                     class="form-control" 
                     value="{{ $nilai_siswa->get($row->siswa->id)->deskripsi ?? '' }}">
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <button class="btn btn-success mt-3" type="submit">Simpan</button>
    </form>
  </div>
</div>
@endsection
