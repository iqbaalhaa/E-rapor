@extends('layouts.main')

@section('title', 'Tambah Siswa oleh Wali Kelas')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Form Tambah Siswa</h4>
    <p class="card-description">
      Siswa akan ditambahkan ke kelas <strong>{{ $waliKelas->kelas->nama_kelas }}</strong>
      untuk tahun ajaran <strong>{{ $tahun->nama_tahun_akademik }} ({{ $tahun->semester }})</strong>.
    </p>

    <form action="{{ route('walikelas.siswa.store') }}" method="POST">
      @csrf
      <input type="hidden" name="kelas_id" value="{{ $waliKelas->kelas_id }}">
      <input type="hidden" name="tahun_akademik_id" value="{{ $tahun->id }}">

      <div class="form-group">
        <label for="nama">Nama Siswa</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
        @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <label for="nis">NIS</label>
        <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" value="{{ old('nis') }}" required>
        @error('nis')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <label for="nisn">NISN</label>
        <input type="text" class="form-control" id="nisn" name="nisn" value="{{ old('nisn') }}">
      </div>
      <div class="form-group">
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
          <option value="">Pilih Jenis Kelamin</option>
          <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
          <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('jenis_kelamin')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
      </div>
      <div class="form-group">
        <label for="no_hp">No. HP</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}">
      </div>

      <button type="submit" class="btn btn-primary mr-2">Simpan</button>
      <a href="{{ url()->previous() }}" class="btn btn-light">Batal</a>
    </form>
  </div>
</div>
@endsection 