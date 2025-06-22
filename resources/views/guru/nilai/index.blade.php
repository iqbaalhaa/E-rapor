@extends('layouts.main')

@section('title', 'Input Nilai')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Jadwal Mengajar</h4>
                <p class="card-description">
                    Pilih kelas dan mata pelajaran yang Anda ampu untuk mulai menginput atau mengubah nilai siswa.
                </p>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12">
        <div class="alert alert-info">
            <h5 class="alert-heading"><i class="ti-info-alt"></i> Panduan Penilaian</h5>
            <p>Berikut adalah rentang nilai dan predikat yang digunakan dalam sistem:</p>
            <ul>
                <li><strong>A (Sangat Baik):</strong> Nilai > 80</li>
                <li><strong>B (Baik):</strong> Nilai 70 - 79</li>
                <li><strong>C (Cukup):</strong> Nilai 60 - 69</li>
                <li><strong>D (Kurang):</strong> Nilai 50 - 59</li>
                <li><strong>E (Sangat Kurang):</strong> Nilai < 50</li>
            </ul>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pilih Kelas & Mapel</h4>
                @if($jadwal->isEmpty())
                <div class="alert alert-warning">
                    <i class="ti-alert"></i> Belum ada jadwal mengajar yang terdaftar untuk Anda pada tahun akademik aktif.
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th width="15%">Jumlah Siswa</th>
                                <th width="15%">Status Nilai</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwal as $index => $item)
                            @php
                                $jumlah_siswa = \App\Models\KelasSiswa::where('kelas_id', $item->kelas_id)->where('tahun_akademik_id', $item->tahun_akademik_id)->count();
                                $nilai_terinput = \App\Models\NilaiSiswa::where('mapel_id', $item->mapel_id)
                                    ->where('kelas_id', $item->kelas_id)
                                    ->where('guru_id', auth()->user()->guru->id)
                                    ->where('tahun_akademik_id', $item->tahun_akademik_id)
                                    ->count();
                                $status_lengkap = $jumlah_siswa > 0 && $nilai_terinput >= $jumlah_siswa;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->kelas->nama_kelas }}</td>
                                <td>{{ $item->mapel->nama }}</td>
                                <td>{{ $jumlah_siswa }} Siswa</td>
                                <td>
                                    @if($status_lengkap)
                                        <span class="badge badge-success">Lengkap</span>
                                    @else
                                        <span class="badge badge-warning">Belum Lengkap</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('input-nilai.show', $item->id) }}" class="btn btn-primary btn-sm">
                                        <i class="ti-pencil-alt"></i> 
                                        {{ $nilai_terinput > 0 ? 'Edit Nilai' : 'Input Nilai' }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
