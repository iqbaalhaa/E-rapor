<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor - {{ $siswa->nama ?? 'Siswa' }}</title>
    <style>
        * { 
            font-family: 'Times New Roman', serif; 
            font-size: 12px; 
            line-height: 1.4;
        }
        
        body {
            margin: 20px;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .header h3 {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }
        
        .header h4 {
            font-size: 14px;
            font-weight: bold;
            margin: 5px 0;
        }
        
        .header p {
            font-size: 12px;
            margin: 5px 0;
        }
        
        table { 
            border-collapse: collapse; 
            width: 100%; 
            margin-bottom: 15px; 
        }
        
        th, td { 
            border: 1px solid #000; 
            padding: 6px; 
            vertical-align: top; 
        }
        
        .no-border td { 
            border: none; 
            padding: 2px 6px;
        }
        
        .text-center { 
            text-align: center; 
        }
        
        .text-left { 
            text-align: left; 
        }
        
        .text-bold { 
            font-weight: bold; 
        }
        
        .page-break { 
            page-break-after: always; 
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 15px 0 10px 0;
            text-transform: uppercase;
        }
        
        .info-table td:first-child {
            font-weight: bold;
            width: 25%;
        }
        
        .signature-box {
            border: 1px solid #000;
            padding: 10px;
            min-height: 80px;
            margin: 10px 0;
        }
        
        .signature-area {
            margin-top: 30px;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 5px;
        }
        
        .empty-row td {
            height: 20px;
        }
        
        .nilai-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .footer-note {
            font-size: 10px;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h3>LAPORAN HASIL BELAJAR</h3>
        <h4>MADRASAH TSANAWIYAH NEGERI (MTsN) 3 INDRAGIRI HILIR</h4>
        <p>(Terakreditasi B)</p>
        <p>Jl. Teratai, Enok, Kec. Enok, Kabupaten Indragiri Hilir, Riau</p>
    </div>

    <table class="no-border info-table">
        <tr>
            <td>Nama Peserta Didik</td>
            <td>: {{ $siswa->nama ?? 'Nama Siswa' }}</td>
            <td>Kelas</td>
            <td>: {{ $kelas->nama_kelas ?? 'Kelas' }}</td>
        </tr>
        <tr>
            <td>NIS/NISN</td>
            <td>: {{ $siswa->nis ?? 'NIS' }}/{{ $siswa->nisn ?? 'NISN' }}</td>
            <td>Fase</td>
            <td>: D</td>
        </tr>
        <tr>
            <td>Madrasah</td>
            <td>: MTsN 3 Indragiri Hilir</td>
            <td>Semester</td>
            <td>: {{ $semester ?? 'Ganjil' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $siswa->alamat ?? 'Jl. Teratai, Enok' }}</td>
            <td>Tahun Pelajaran</td>
            <td>: {{ $tahun->tahun ?? '2024/2025' }}</td>
        </tr>
    </table>

    <div class="section-title">CAPAIAN HASIL BELAJAR</div>

    <table class="nilai-table">
        <thead>
            <tr class="text-center">
                <th width="5%">No</th>
                <th width="35%">Mata Pelajaran</th>
                <th width="15%">Nilai Akhir</th>
                <th width="45%">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $kelompok_mapel = [
                'Pendidikan Agama Islam' => [
                    'Al Qur\'an Hadis',
                    'Akidah Akhlak',
                    'Fikih',
                    'Sejarah Kebudayaan Islam',
                ],
                'Bahasa Arab' => [
                    'Bahasa Arab',
                ],
                'Pendidikan Pancasila' => [
                    'Pendidikan Pancasila',
                ],
                'Bahasa Indonesia' => [
                    'Bahasa Indonesia',
                ],
                'Matematika' => [
                    'Matematika',
                ],
                'Ilmu Pengetahuan Alam (IPA)' => [
                    'Ilmu Pengetahuan Alam (IPA)',
                ],
                'Ilmu Pengetahuan Sosial (IPS)' => [
                    'Ilmu Pengetahuan Sosial (IPS)',
                ],
                'Bahasa Inggris' => [
                    'Bahasa Inggris',
                ],
            ];
            $no = 1;
            @endphp
            @foreach($kelompok_mapel as $kelompok => $mapels)
                @php
                    $ada_mapel = false;
                    foreach($mapels as $mapel_nama) {
                        $n = $nilai->first(function($item) use ($mapel_nama) {
                            return strtolower(trim($item->mapel->nama ?? '')) == strtolower(trim($mapel_nama));
                        });
                        if ($n) { $ada_mapel = true; break; }
                    }
                @endphp
                @if($ada_mapel)
                    <tr>
                        <td colspan="4" class="text-bold">{{ $kelompok }}</td>
                    </tr>
                    @foreach($mapels as $mapel_nama)
                        @php
                            $n = $nilai->first(function($item) use ($mapel_nama) {
                                return strtolower(trim($item->mapel->nama ?? '')) == strtolower(trim($mapel_nama));
                            });
                        @endphp
                        @if($n)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $mapel_nama }}</td>
                            <td class="text-center">{{ $n->nilai_pengetahuan ?? '-' }}</td>
                            <td>{{ $n->deskripsi ?? '-' }}</td>
                        </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Ekstrakurikuler</div>
    <table>
        <thead>
            <tr class="text-center">
                <th width="10%">No</th>
                <th width="40%">Kegiatan Ekstrakurikuler</th>
                <th width="15%">Nilai</th>
                <th width="35%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($ekstrakurikuler) && count($ekstrakurikuler) > 0)
                @foreach($ekstrakurikuler as $index => $eks)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $eks->nama_ekskul ?? 'Ekstrakurikuler' }}</td>
                    <td class="text-center">{{ $eks->nilai ?? '-' }}</td>
                    <td>{{ $eks->keterangan ?? 'Keterangan belum tersedia' }}</td>
                </tr>
                @endforeach
            @else
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
            @endif
        </tbody>
    </table>

    <div class="section-title">Prestasi</div>
    <table>
        <thead>
            <tr class="text-center">
                <th width="10%">No</th>
                <th width="40%">Jenis Prestasi</th>
                <th width="50%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($prestasi) && count($prestasi) > 0)
                @foreach($prestasi as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->jenis_prestasi ?? 'Prestasi' }}</td>
                    <td>{{ $p->keterangan ?? 'Keterangan prestasi' }}</td>
                </tr>
                @endforeach
            @else
                <tr class="empty-row">
                    <td class="text-center">1</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="empty-row">
                    <td class="text-center">2</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="section-title">Ketidakhadiran</div>
    <table style="width: 50%;">
        <tbody>
            <tr>
                <td width="40%"><strong>Sakit</strong></td>
                <td>: {{ $ketidakhadiran->sakit ?? 0 }} hari</td>
            </tr>
            <tr>
                <td><strong>Izin</strong></td>
                <td>: {{ $ketidakhadiran->izin ?? 0 }} hari</td>
            </tr>
            <tr>
                <td><strong>Tanpa Keterangan</strong></td>
                <td>: {{ $ketidakhadiran->tanpa_keterangan ?? 0 }} hari</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Catatan Wali Kelas</div>
    <div class="signature-box">
        {{ $catatan_walikelas ?? 'Ananda ' . ($siswa->nama ?? 'siswa') . ', kedisiplinan dan prestasi belajarmu menunjukkan pencapaian yang positif. Teruslah berusaha untuk meningkatkan kemampuan akademik dan non-akademik. Pertahankan sikap positif dan semangat belajar yang tinggi.' }}
    </div>

    <div class="section-title">Tanggapan Orang Tua / Wali</div>
    <div class="signature-box">
        {{ $tanggapan_ortu ?? '' }}
    </div>

    <div class="signature-area">
        <table class="no-border">
            <tr>
                <td width="50%" style="vertical-align: top;">
                    Orang Tua/Wali,<br><br><br><br>
                    <div class="signature-line">
                        ________________________
                    </div>
                </td>
                <td style="vertical-align: top;">
                    Sungai Penuh, {{ $tanggal_cetak ?? '21 Desember 2024' }}<br>
                    Wali Kelas<br><br><br><br>
                    <div class="signature-line">
                        <strong>{{ $walikelas->nama ?? 'SALIMAH, S.PdI, M.PdI' }}</strong><br>
                        NIP. {{ $walikelas->nip ?? '196902122007012034' }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="signature-area">
        <table class="no-border">
            <tr>
                <td style="text-align: right; vertical-align: top;">
                    Mengetahui,<br>Kepala Madrasah<br><br><br><br>
                    <div class="signature-line">
                        <strong>{{ $kepsek->nama ?? 'SYAFRI JUANA, S.Pd, M.Pd' }}</strong><br>
                        NIP. {{ $kepsek->nip ?? '197710012002121002' }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer-note">
        <p><strong>Catatan:</strong></p>
        <p>Nilai A = Sangat Baik (86-100) | B = Baik (71-85) | C = Cukup (56-70) | D = Kurang (0-55)</p>
        <p>Rapor ini dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

</body>
</html> 