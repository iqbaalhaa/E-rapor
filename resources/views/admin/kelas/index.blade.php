@extends('layouts.main')

@section('title', 'Data Kelas')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Daftar Kelas</h4>
    <a href="{{ route('kelas.create') }}" class="btn btn-primary mb-3">+ Tambah</a>
    <table class="table table-bordered">
          <thead>
        <tr>
          <th>No.</th>
          <th>Nama</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($kelas as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><b>{{ $item->nama_kelas }}</b></td>
          <td>
            <a href="{{ route('kelas.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('kelas.destroy', $item->id) }}" method="POST" style="display:inline;">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus kelas?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
