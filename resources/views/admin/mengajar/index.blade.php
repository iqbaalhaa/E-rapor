@extends('layouts.main')

@section('title', 'Jadwal Mengajar')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Data Jadwal Mengajar</h4>
    <a href="{{ route('mengajar.create') }}" class="btn btn-primary mb-3">+ Tambah</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No.</th>
          <th>Guru</th>
          <th>Mata Pelajaran</th>
          <th>Kelas</th>
          <th>Tahun Ajaran</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->guru->nama }}</td>
          <td>{{ $item->mapel->nama }}</td>
          <td>{{ $item->kelas->nama_kelas }}</td>
          <td>{{ $item->tahunAkademik->tahun }}</td>
          <td>
            <a href="{{ route('mengajar.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('mengajar.destroy', $item->id) }}" method="POST" style="display:inline;">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
