@extends('layouts.main')

@section('title', 'Data Guru')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Daftar Guru</h4>
    <a href="{{ route('guru.create') }}" class="btn btn-primary mb-3">+ Tambah Guru</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama</th>
          <th>NIP</th>
          <th>Email</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($guru as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->nama }}</td>
          <td>{{ $item->nip }}</td>
          <td>{{ $item->email }}</td>
          <td>
            <a href="{{ route('guru.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('guru.destroy', $item->id) }}" method="POST" style="display:inline;">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
