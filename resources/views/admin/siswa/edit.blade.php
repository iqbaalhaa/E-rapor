@extends('layouts.main')

@section('title', 'Edit Siswa')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Edit Siswa</h4>
    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
      @method('PUT')
      @include('admin.siswa.form')
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection
