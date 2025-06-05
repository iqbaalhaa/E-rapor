@extends('layouts.main')
@section('title', 'Tambah Jadwal')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Tambah Jadwal Mengajar</h4>

    <form action="{{ route('jadwal-mengajar.store') }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Guru</label>
        <select name="guru_id" class="form-control" required>
          <option value="">-- Pilih Guru --</option>
          @foreach($guru as $g)
            <option value="{{ $g->id }}">{{ $g->nama }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Mata Pelajaran</label>
        <select name="mapel_id" class="form-control" required>
          <option value="">-- Pilih Mapel --</option>
          @foreach($mapel as $m)
            <option value="{{ $m->id }}">{{ $m->nama }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="{{ route('jadwal-mengajar.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</div>
@endsection
