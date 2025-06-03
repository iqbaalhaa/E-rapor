@extends('layouts.main')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">{{ isset($mapel) ? 'Edit' : 'Tambah' }} Mata Pelajaran</h4>
    <form action="{{ isset($mapel) ? route('mapel.update', $mapel->id) : route('mapel.store') }}" method="POST">
      @isset($mapel)
        @method('PUT')
      @endisset
      @include('admin.mapel.form')
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
