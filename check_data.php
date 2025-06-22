<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Data Guru ===\n";
$gurus = \App\Models\Guru::all();
foreach ($gurus as $guru) {
    echo "ID: {$guru->id}, Nama: {$guru->nama}, User ID: {$guru->user_id}\n";
}

echo "\n=== Data Jadwal Mengajar (Raw) ===\n";
$jadwalRaw = \DB::table('jadwal_mengajar')->get();
foreach ($jadwalRaw as $j) {
    echo "ID: {$j->id}, Guru ID: {$j->guru_id}, Mapel ID: {$j->mapel_id}, Kelas ID: {$j->kelas_id}\n";
}

echo "\n=== Data Jadwal Mengajar (With Relations) ===\n";
$jadwal = \App\Models\Mengajar::with(['guru', 'mapel', 'kelas'])->get();
foreach ($jadwal as $j) {
    echo "ID: {$j->id}, Guru: {$j->guru->nama}, Mapel: {$j->mapel->nama}, Kelas: {$j->kelas->nama_kelas}\n";
}

echo "\n=== Data Mapel ===\n";
$mapels = \App\Models\Mapel::all();
foreach ($mapels as $mapel) {
    echo "ID: {$mapel->id}, Kode: {$mapel->kode}, Nama: {$mapel->nama}\n";
}

echo "\n=== Data Kelas ===\n";
$kelas = \App\Models\Kelas::all();
foreach ($kelas as $k) {
    echo "ID: {$k->id}, Nama: {$k->nama_kelas}\n";
} 