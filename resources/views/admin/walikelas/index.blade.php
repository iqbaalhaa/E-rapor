@extends('layouts.main')

@section('title', 'Wali Kelas')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Daftar Wali Kelas</h4>
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('wali-kelas.create') }}" class="btn btn-primary">
                <i class="ti-plus"></i> Tambah Wali Kelas
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="waliKelasTable">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th>Guru</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->guru ? $item->guru->nama : 'Data guru tidak ditemukan' }}</td>
                        <td>{{ $item->kelas ? $item->kelas->nama_kelas : 'Data kelas tidak ditemukan' }}</td>
                        <td>{{ $item->tahunAkademik ? $item->tahunAkademik->tahun : 'Data tahun akademik tidak ditemukan' }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <form action="{{ route('wali-kelas.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="ti-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#waliKelasTable').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            "pageLength": 10,
            "ordering": true
        });
    });
</script>
@endpush
