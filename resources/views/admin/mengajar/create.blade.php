@extends('layouts.main')

@section('title', 'Tambah Jadwal Mengajar')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Tambah Jadwal Mengajar</h4>
    <form action="{{ route('mengajar.store') }}" method="POST">
      @include('admin.mengajar.form')
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
