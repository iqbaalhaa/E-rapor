@extends('layouts.main')

@section('title', 'Pengguna Sistem')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Daftar Pengguna Sistem</h4>
    <a href="{{ route('user.create') }}" class="btn btn-primary mb-3">+ Tambah</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No.</th>
          <th>Username</th>
          <th>Nama</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ ucfirst($user->role) }}</td>
          <td>
            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus user?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
