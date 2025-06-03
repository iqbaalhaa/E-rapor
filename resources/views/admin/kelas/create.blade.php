@extends('layouts.main')

@section('title', 'Tambah Kelas')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Tambah Kelas</h4>
    <form action="{{ route('kelas.store') }}" method="POST">
      @include('admin.kelas.form')
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
