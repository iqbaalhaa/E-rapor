@extends('layouts.main')

@section('title', 'Edit Guru')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Edit Guru</h4>
    <form action="{{ route('guru.update', $guru->id) }}" method="POST">
      @method('PUT')
      @include('admin.guru.form')
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection
