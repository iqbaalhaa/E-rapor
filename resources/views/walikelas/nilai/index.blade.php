@extends('layouts.main')
@section('title', 'Nilai dari Guru')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Daftar Siswa Kelas Wali</h4>
    <table class="table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($siswa as $row)
        <tr>
          <td>{{ $row->siswa->nama }}</td>
          <td>
            <a href="{{ route('nilai-guru.edit', $row->siswa->id) }}" class="btn btn-sm btn-info">Lihat & Koreksi Nilai</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
