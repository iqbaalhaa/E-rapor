@extends('layouts.main')

@section('title', 'Data Guru')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Daftar Guru</h4>
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('guru.create') }}" class="btn btn-primary">
                <i class="ti-plus"></i> Tambah Guru
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="guruTable">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Email</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guru as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->nip }}</td>
                        <td>{{ $item->email }}</td>
                        <td class="text-center">
                          <a href="{{ route('guru.edit', $item->id) }}" class="btn btn-warning btn-md" title="Edit">
                            <i class="ti-pencil"></i>
                          </a>
                          <form action="{{ route('guru.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-md" title="Hapus">
                              <i class="ti-trash"></i>
                            </button>
                          </form>
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
        $('#guruTable').DataTable({
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
