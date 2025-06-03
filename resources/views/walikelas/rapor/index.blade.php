@extends('layouts.main')
@section('title', 'Cetak Rapor')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Daftar Siswa</h4>

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
            <a href="{{ route('rapor.show', $row->siswa->id) }}" class="btn btn-sm btn-success" target="_blank">Cetak Rapor</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
