@extends('layouts.main')

@section('title', 'Tambah Wali Kelas')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Tetapkan Wali Kelas</h4>
    <form action="{{ route('wali-kelas.store') }}" method="POST">
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
        <label>Kelas</label>
        <select name="kelas_id" class="form-control" required>
          <option value="">-- Pilih Kelas --</option>
          @foreach($kelas as $k)
            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Tahun Akademik</label>
        @if($tahun)
          <input type="hidden" name="tahun_akademik_id" value="{{ $tahun->id }}">
          <input type="text" class="form-control" value="{{ $tahun->tahun }}" readonly>
        @else
          <div class="alert alert-warning">Tahun akademik aktif belum tersedia.</div>
        @endif
      </div>

      <button class="btn btn-primary" type="submit">Simpan</button>
    </form>
  </div>
</div>
@endsection
