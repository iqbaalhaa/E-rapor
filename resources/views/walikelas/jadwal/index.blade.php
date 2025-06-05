@extends('layouts.main')
@section('title', 'Atur Jadwal Mengajar')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Jadwal Mengajar - Kelas {{ $wali->kelas->nama_kelas }}</h4>
    <a href="{{ route('jadwal-mengajar.create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>

    <table class="table">
      <thead>
        <tr>
          <th>Guru</th>
          <th>Mata Pelajaran</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($jadwal as $item)
        <tr>
          <td>{{ $item->guru->nama }}</td>
          <td>{{ $item->mapel->nama }}</td>
          <td>
            <form action="{{ route('jadwal-mengajar.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
