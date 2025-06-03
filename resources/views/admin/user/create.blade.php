@extends('layouts.main')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Tambah Pengguna</h4>
    <form action="{{ route('user.store') }}" method="POST">
      @include('admin.user.form')
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
