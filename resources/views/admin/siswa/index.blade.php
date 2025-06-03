@extends('layouts.main')

@section('title', 'Data Siswa')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Daftar Siswa</h4>
    <a href="{{ route('siswa.create') }}" class="btn btn-primary mb-3">+ Tambah Siswa</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama</th>
          <th>NIS</th>
          <th>JK</th>
          <th>Kelas</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($siswa as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->nama }}</td>
          <td>{{ $item->nis }}</td>
          <td>{{ $item->jenis_kelamin }}</td>
          <td>{{ $item->kelasSiswa->first() ? $item->kelasSiswa->first()->kelas->nama_kelas : '-' }}</td>
          <td>
            <a href="{{ route('siswa.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('siswa.destroy', $item->id) }}" method="POST" style="display:inline;">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus siswa?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
