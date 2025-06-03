@extends('layouts.main')

@section('title', 'Tahun Akademik')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Daftar Tahun Akademik</h4>
    <a href="{{ route('tahun-akademik.create') }}" class="btn btn-primary mb-3">+ Tambah</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No.</th>
          <th>Tahun</th>
          <th>Semester</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($tahunAkademik as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->tahun }}</td>
          <td>{{ $item->semester }}</td>
          <td>
            @if($item->is_active)
              <span class="badge badge-success">Aktif</span>
            @else
              <span class="badge badge-secondary">Nonaktif</span>
            @endif
          </td>
          <td>
            <a href="{{ route('tahun-akademik.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('tahun-akademik.destroy', $item->id) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
