@extends('layouts.main')

@section('title', 'Input Nilai')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Daftar Kelas dan Mapel</h4>
    <ul>
      @foreach($jadwal as $item)
      <li>
        <a href="{{ route('input-nilai.show', $item->id) }}">
          {{ $item->kelas->nama_kelas }} - {{ $item->mapel->nama_mapel }}
        </a>
      </li>
      @endforeach
    </ul>
  </div>
</div>
@endsection
