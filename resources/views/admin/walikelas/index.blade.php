@extends('layouts.main')

@section('title', 'Wali Kelas')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Daftar Wali Kelas</h4>
    <a href="{{ route('wali-kelas.create') }}" class="btn btn-primary mb-3">+ Tambah</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No.</th>
          <th>Guru</th>
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
          <td>{{ $item->kelas->nama_kelas }}</td>
          <td>{{ $item->tahunAkademik->tahun }}</td>
          <td>
            <form action="{{ route('wali-kelas.destroy', $item->id) }}" method="POST">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
