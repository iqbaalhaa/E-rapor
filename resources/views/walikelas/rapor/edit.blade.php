@extends('layouts.main')

@section('content')

@if(session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Input Data Rapor untuk Siswa: {{ $siswa->nama }}</h4>
                <p class="card-category">Tahun Ajaran: {{ $tahun->tahun }} - Semester {{ $tahun->semester }}</p>
            </div>
            <div class="card-body">
                <form action="{{ route('rapor.update', $siswa->id) }}" method="POST">
                    @csrf
                    
                    {{-- Catatan Wali Kelas --}}
                    <div class="form-group">
                        <label for="catatan_walikelas">Catatan Wali Kelas</label>
                        <textarea name="catatan_walikelas" id="catatan_walikelas" class="form-control" rows="3">{{ old('catatan_walikelas', $catatan->catatan) }}</textarea>
                    </div>

                    {{-- Ketidakhadiran --}}
                    <h5>Ketidakhadiran</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sakit">Sakit (hari)</label>
                                <input type="number" name="sakit" id="sakit" class="form-control" value="{{ old('sakit', $ketidakhadiran->sakit) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="izin">Izin (hari)</label>
                                <input type="number" name="izin" id="izin" class="form-control" value="{{ old('izin', $ketidakhadiran->izin) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tanpa_keterangan">Tanpa Keterangan (hari)</label>
                                <input type="number" name="tanpa_keterangan" id="tanpa_keterangan" class="form-control" value="{{ old('tanpa_keterangan', $ketidakhadiran->tanpa_keterangan) }}">
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Prestasi --}}
                    <h5>Prestasi</h5>
                    <div id="prestasi-wrapper">
                        @forelse($prestasi as $index => $p)
                        <div class="row prestasi-item mb-2">
                            <div class="col-md-5">
                                <input type="text" name="prestasi[{{ $index }}][jenis_prestasi]" class="form-control" placeholder="Jenis Prestasi" value="{{ $p->jenis_prestasi }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="prestasi[{{ $index }}][keterangan]" class="form-control" placeholder="Keterangan" value="{{ $p->keterangan }}">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-prestasi">Hapus</button>
                            </div>
                        </div>
                        @empty
                        <div class="row prestasi-item mb-2">
                            <div class="col-md-5">
                                <input type="text" name="prestasi[0][jenis_prestasi]" class="form-control" placeholder="Jenis Prestasi">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="prestasi[0][keterangan]" class="form-control" placeholder="Keterangan">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-prestasi">Hapus</button>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <button type="button" id="add-prestasi" class="btn btn-primary btn-sm mt-2">Tambah Prestasi</button>

                    <hr>

                    {{-- Ekstrakurikuler --}}
                    <h5>Ekstrakurikuler</h5>
                    <div id="ekskul-wrapper">
                        @forelse($ekstrakurikuler as $index => $eks)
                        <div class="row ekskul-item mb-2">
                            <div class="col-md-4">
                                <input type="text" name="ekskul[{{ $index }}][nama_ekskul]" class="form-control" placeholder="Nama Ekstrakurikuler" value="{{ $eks->nama_ekskul }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="ekskul[{{ $index }}][nilai]" class="form-control" placeholder="Nilai" value="{{ $eks->nilai }}">
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="ekskul[{{ $index }}][keterangan]" class="form-control" placeholder="Keterangan" value="{{ $eks->keterangan }}">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-ekskul">Hapus</button>
                            </div>
                        </div>
                        @empty
                        <div class="row ekskul-item mb-2">
                            <div class="col-md-4">
                                <input type="text" name="ekskul[0][nama_ekskul]" class="form-control" placeholder="Nama Ekstrakurikuler">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="ekskul[0][nilai]" class="form-control" placeholder="Nilai">
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="ekskul[0][keterangan]" class="form-control" placeholder="Keterangan">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-ekskul">Hapus</button>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <button type="button" id="add-ekskul" class="btn btn-primary btn-sm mt-2">Tambah Ekstrakurikuler</button>

                    <hr>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <a href="{{ route('rapor.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Prestasi
    let prestasiIndex = {{ count($prestasi) }};
    document.getElementById('add-prestasi').addEventListener('click', function () {
        prestasiIndex++;
        const wrapper = document.getElementById('prestasi-wrapper');
        const newItem = `
            <div class="row prestasi-item mb-2">
                <div class="col-md-5">
                    <input type="text" name="prestasi[${prestasiIndex}][jenis_prestasi]" class="form-control" placeholder="Jenis Prestasi">
                </div>
                <div class="col-md-6">
                    <input type="text" name="prestasi[${prestasiIndex}][keterangan]" class="form-control" placeholder="Keterangan">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-prestasi">Hapus</button>
                </div>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', newItem);
    });

    document.getElementById('prestasi-wrapper').addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-prestasi')) {
            e.target.closest('.prestasi-item').remove();
        }
    });

    // Ekstrakurikuler
    let ekskulIndex = {{ count($ekstrakurikuler) }};
    document.getElementById('add-ekskul').addEventListener('click', function () {
        ekskulIndex++;
        const wrapper = document.getElementById('ekskul-wrapper');
        const newItem = `
            <div class="row ekskul-item mb-2">
                <div class="col-md-4">
                    <input type="text" name="ekskul[${ekskulIndex}][nama_ekskul]" class="form-control" placeholder="Nama Ekstrakurikuler">
                </div>
                <div class="col-md-2">
                    <input type="text" name="ekskul[${ekskulIndex}][nilai]" class="form-control" placeholder="Nilai">
                </div>
                <div class="col-md-5">
                    <input type="text" name="ekskul[${ekskulIndex}][keterangan]" class="form-control" placeholder="Keterangan">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-ekskul">Hapus</button>
                </div>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', newItem);
    });

    document.getElementById('ekskul-wrapper').addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-ekskul')) {
            e.target.closest('.ekskul-item').remove();
        }
    });
});
</script>
@endpush 