@extends('layouts.main')

@section('title', 'Dashboard Guru')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Selamat Datang, {{ auth()->user()->name }}</h4>
    <p>Berikut adalah daftar kelas dan mata pelajaran yang Anda ampu:</p>

    

  </div>
</div>
@endsection
