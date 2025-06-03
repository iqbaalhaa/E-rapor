@extends('layouts.main')

@section('title', 'Tambah Tahun Akademik')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Tambah Tahun Akademik</h4>
    <form action="{{ route('tahun-akademik.store') }}" method="POST">
      @include('admin.tahun_akademik.form')
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
