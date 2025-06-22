@extends('layouts.main')

@section('title', 'Data Siswa Kelas ' . $waliKelas->kelas->nama_kelas)

@section('content')
<div class="card">
  <div class="card-body">
    @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif
    <h4 class="card-title">Daftar Siswa - Kelas {{ $waliKelas->kelas->nama_kelas }}</h4>
    <a href="{{ route('walikelas.siswa.create') }}" class="btn btn-primary mb-3">+ Tambah Siswa</a>
    <div class="table-responsive">
      <table class="table table-bordered" id="siswa-table">
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>NIS</th>
            <th>JK</th>
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
            <td>
              {{-- Aksi seperti edit/hapus bisa ditambahkan di sini jika perlu --}}
              <a href="#" class="btn btn-info btn-sm">Detail</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $('#siswa-table').DataTable();
  });
</script>
@endpush 