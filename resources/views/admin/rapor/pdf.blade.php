<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor - {{ $siswa->nama }}</title>
    <style>
        * { font-family: sans-serif; font-size: 11px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 4px; vertical-align: top; }
        .no-border td { border: none; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-bold { font-weight: bold; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    <h3 class="text-center">LAPORAN HASIL BELAJAR</h3>
    <h4 class="text-center">MADRASAH TSANAWIYAH NEGERI (MTsN) 2 SUNGAI PENUH</h4>
    <p class="text-center">(Terakreditasi B)</p>

    <table class="no-border">
        <tr>
            <td>Nama Peserta Didik</td><td>: {{ $siswa->nama }}</td>
            <td>Kelas</td><td>: {{ $kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td>NIS/NISN</td><td>: {{ $siswa->nis }}/{{ $siswa->nisn }}</td>
            <td>Fase</td><td>: D</td>
        </tr>
        <tr>
            <td>Madrasah</td><td>: MTsN 2 Sungai Penuh</td>
            <td>Semester</td><td>: Ganjil</td>
        </tr>
        <tr>
            <td>Alamat</td><td>: Jl. Relay TVRI Hamparan Rawang</td>
            <td>Tahun Pelajaran</td><td>: {{ $tahun->tahun }}</td>
        </tr>
    </table>

    <h4>CAPAIAN HASIL BELAJAR</h4>

    <table>
        <thead>
            <tr class="text-center">
                <th rowspan="2">No</th>
                <th rowspan="2">Mata Pelajaran</th>
                <th rowspan="2">Nilai Akhir</th>
                <th colspan="1">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($nilai as $n)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $n->mapel->nama_mapel }}</td>
                <td class="text-center">{{ $n->nilai_pengetahuan }}</td>
                <td>{{ $n->deskripsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Ekstrakurikuler</h4>
    <table>
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Kegiatan Ekstrakurikuler</th>
                <th>Nilai</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>OSIM</td>
                <td class="text-center">B</td>
                <td>Baik, loyal terhadap organisasi dan aktif dalam kegiatan OSIM</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>PMR</td>
                <td class="text-center">B</td>
                <td>Baik, pertahankan kerja sama dengan anggota PMR</td>
            </tr>
        </tbody>
    </table>

    <h4>Prestasi</h4>
    <table>
        <thead>
            <tr class="text-center">
                <th>No</th><th>Jenis Prestasi</th><th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr><td class="text-center">1</td><td></td><td></td></tr>
            <tr><td class="text-center">2</td><td></td><td></td></tr>
        </tbody>
    </table>

    <h4>Ketidakhadiran</h4>
    <table>
        <tbody>
            <tr><td>Sakit</td><td>: 0 hari</td></tr>
            <tr><td>Izin</td><td>: 2 hari</td></tr>
            <tr><td>Tanpa Keterangan</td><td>: 0 hari</td></tr>
        </tbody>
    </table>

    <h4>Catatan Wali Kelas</h4>
    <p style="border:1px solid #000; padding:6px;">
        Ananda {{ $siswa->nama }}, kedisiplinan dan prestasi belajarmu menunjukkan pencapaian yang positif...
    </p>

    <h4>Tanggapan Orang Tua / Wali</h4>
    <p style="border:1px solid #000; height: 60px;"></p>

    <br><br>
    <table class="no-border">
        <tr>
            <td width="50%">Orang Tua,<br><br><br>________________________</td>
            <td>
                Sungai Penuh, 21 Desember 2024<br>
                Wali Kelas<br><br><br>
                <strong>SALIMAH, S.PdI, M.PdI</strong><br>
                NIP. 196902122007012034
            </td>
        </tr>
    </table>

    <br><br>
    <table class="no-border">
        <tr>
            <td align="right">
                Mengetahui,<br>Kepala Madrasah<br><br><br>
                <strong>SYAFRI JUANA, S.Pd, M.Pd</strong><br>
                NIP. 197710012002121002
            </td>
        </tr>
    </table>

</body>
</html>
