@extends('layouts.main')
@section('title', 'Cetak Rapor')

@section('content')
@if(session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
            <a href="{{ route('rapor.show', $row->siswa->id) }}" class="btn btn-primary btn-sm" target="_blank">
              <i class="mdi mdi-printer"></i> Cetak Rapor
            </a>
            <a href="{{ route('rapor.edit', $row->siswa->id) }}" class="btn btn-warning btn-sm">
              <i class="mdi mdi-pencil"></i> Input Rapor
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
