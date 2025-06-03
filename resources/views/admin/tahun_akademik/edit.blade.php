@extends('layouts.main')

@section('title', 'Edit Tahun Akademik')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Edit Tahun Akademik</h4>
    <form action="{{ route('tahun-akademik.update', $tahunAkademik->id) }}" method="POST">
      @method('PUT')
      @include('admin.tahun_akademik.form')
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection
