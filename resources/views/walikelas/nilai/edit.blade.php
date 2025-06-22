@extends('layouts.main')
@section('title', 'Edit Nilai Siswa')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Nilai {{ $siswa->nama }}</h4>

    <form action="{{ route('nilai-guru.update', $siswa->id) }}" method="POST">
      @csrf
      @method('PUT')

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Mata Pelajaran</th>
            <th>Guru</th>
            <th>Pengetahuan</th>
            <th>Keterampilan</th>
            <th>Deskripsi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($nilai as $n)
          <tr>
            <td>{{ $n->mapel->nama }}</td>
            <td>{{ $n->guru->nama }}</td>
            <td><input type="number" name="nilai[{{ $n->id }}][pengetahuan]" value="{{ $n->nilai_pengetahuan }}" class="form-control"></td>
            <td><input type="number" name="nilai[{{ $n->id }}][keterampilan]" value="{{ $n->nilai_keterampilan }}" class="form-control"></td>
            <td><input type="text" name="nilai[{{ $n->id }}][deskripsi]" value="{{ $n->deskripsi }}" class="form-control"></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <br>

      <button type="submit" class="btn btn-success"><b>Simpan</b></button>
      <a href="{{ route('nilai-guru.index') }}" class="btn btn-secondary"><b>Kembali</b></a>
    </form>
  </div>
</div>
@endsection
