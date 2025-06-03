@extends('layouts.main')

@section('title', 'Edit Kelas')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Edit Kelas</h4>
    <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="form-group">
          <label>Nama Kelas</label>
          <input type="text" name="nama_kelas" class="form-control" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
