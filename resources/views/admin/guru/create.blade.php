@extends('layouts.main')

@section('title', 'Tambah Guru')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Tambah Guru</h4>
    <form action="{{ route('guru.store') }}" method="POST">
      @include('admin.guru.form')
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
