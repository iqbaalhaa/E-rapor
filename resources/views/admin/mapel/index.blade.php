@extends('layouts.main')

@section('title', 'Mata Pelajaran')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Daftar Mata Pelajaran</h4>
    <a href="{{ route('mapel.create') }}" class="btn btn-primary mb-3">+ Tambah</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No.</th>
          <th>Kode</th>
          <th>Nama</th>
          <th>Jenis</th>
          <th>KKM</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($mapel as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->kode }}</td>
          <td>{{ $item->nama }}</td>
          <td>{{ $item->jenis }}</td>
          <td>{{ $item->kkm }}</td>
          <td>
            <a href="{{ route('mapel.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('mapel.destroy', $item->id) }}" method="POST" style="display:inline;">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
