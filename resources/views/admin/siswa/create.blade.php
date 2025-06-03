@extends('layouts.main')

@section('title', 'Tambah Siswa')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Tambah Siswa</h4>
    <form action="{{ route('siswa.store') }}" method="POST">
      @include('admin.siswa.form')
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
