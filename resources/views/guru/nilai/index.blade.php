@extends('layouts.main')

@section('title', 'Input Nilai')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Daftar Kelas dan Mapel</h4>
    
    @if($jadwal->isEmpty())
      <div class="alert alert-warning">
        Belum ada jadwal mengajar yang terdaftar
      </div>
    @else
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Kelas</th>
              <th>Mata Pelajaran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($jadwal as $item)
            <tr>
              <td>{{ $item->kelas->nama_kelas }}</td>
              <td>{{ $item->mapel->nama }}</td>
              <td>
                <a href="{{ route('input-nilai.show', $item->id) }}" class="btn btn-primary btn-sm">
                  Input Nilai
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</div>
@endsection
