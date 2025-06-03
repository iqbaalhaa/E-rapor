@extends('layouts.main')

@section('title', 'Rombongan Belajar')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Rombongan Belajar</h4>
    <a href="{{ route('pindah-kelas.create') }}" class="btn btn-primary mb-3">+ Tambah</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama Siswa</th>
          <th>Kelas</th>
          <th>Tahun Akademik</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->siswa->nama }}</td>
          <td>{{ $item->kelas->nama_kelas }}</td>
          <td>{{ $item->tahunAkademik->tahun }}</td>
          <td>
            <form action="{{ route('pindah-kelas.destroy', $item->id) }}" method="POST">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
