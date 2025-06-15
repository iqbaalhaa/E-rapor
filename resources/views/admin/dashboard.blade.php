@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')

<!-- partial -->
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Selamat Datang, {{ Auth::user()->name }}</h3>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Statistik Guru</h4>
                  <canvas id="guruChart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Statistik Siswa</h4>
                  <canvas id="siswaChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Distribusi Kelas</h4>
                  <canvas id="kelasChart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Statistik Wali Kelas</h4>
                  <canvas id="waliKelasChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card card-tale">
                <div class="card-body">
                  <p class="mb-4">Total Guru</p>
                  <p class="fs-30 mb-2">{{ \App\Models\Guru::count() }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card card-dark-blue">
                <div class="card-body">
                  <p class="mb-4">Total Siswa</p>
                  <p class="fs-30 mb-2">{{ \App\Models\Siswa::count() }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card card-light-blue">
                <div class="card-body">
                  <p class="mb-4">Total Kelas</p>
                  <p class="fs-30 mb-2">{{ \App\Models\Kelas::count() }}</p>
                </div>
              </div>
            </div>
          </div>
      @endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk Guru Chart
    const guruCtx = document.getElementById('guruChart').getContext('2d');
    new Chart(guruCtx, {
        type: 'bar',
        data: {
            labels: ['Total Guru', 'Wali Kelas'],
            datasets: [{
                label: 'Jumlah Guru',
                data: [
                    {{ \App\Models\Guru::count() }},
                    {{ \App\Models\WaliKelas::count() }}
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 2,
                borderRadius: Number.MAX_VALUE,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Statistik Guru'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Data untuk Siswa Chart
    const siswaCtx = document.getElementById('siswaChart').getContext('2d');
    new Chart(siswaCtx, {
        type: 'bar',
        data: {
            labels: ['Total Siswa', 'Siswa Aktif'],
            datasets: [{
                label: 'Jumlah Siswa',
                data: [
                    {{ \App\Models\Siswa::count() }},
                    {{ \App\Models\KelasSiswa::count() }}
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 2,
                borderRadius: Number.MAX_VALUE,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Statistik Siswa'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Data untuk Kelas Chart
    const kelasCtx = document.getElementById('kelasChart').getContext('2d');
    const kelasData = {!! json_encode(\App\Models\Kelas::withCount('kelasSiswa')->get()) !!};
    
    new Chart(kelasCtx, {
        type: 'pie',
        data: {
            labels: kelasData.map(item => item.nama_kelas),
            datasets: [{
                data: kelasData.map(item => item.kelas_siswa_count),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 2,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                title: {
                    display: true,
                    text: 'Distribusi Siswa per Kelas'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw} siswa`;
                        }
                    }
                }
            }
        }
    });

    // Data untuk Wali Kelas Chart
    const waliKelasCtx = document.getElementById('waliKelasChart').getContext('2d');
    const waliKelasData = {!! json_encode(\App\Models\WaliKelas::with(['kelas', 'guru'])->get()) !!};
    
    new Chart(waliKelasCtx, {
        type: 'bar',
        data: {
            labels: waliKelasData.map(item => item.kelas.nama_kelas),
            datasets: [{
                label: 'Jumlah Siswa',
                data: waliKelasData.map(item => item.kelas.kelas_siswa_count),
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                borderRadius: Number.MAX_VALUE,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Siswa per Wali Kelas'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush