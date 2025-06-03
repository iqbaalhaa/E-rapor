@extends('layouts.main')

@section('title', 'Edit Pengguna')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Edit Pengguna</h4>
    <form action="{{ route('user.update', $user->id) }}" method="POST">
      @method('PUT')
      @include('admin.user.form')
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection
