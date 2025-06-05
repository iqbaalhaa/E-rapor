<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    {{-- Dashboard --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/dashboard') }}">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    {{-- ADMIN MENU --}}
    @if(auth()->check() && auth()->user()->role == 'admin')

      {{-- 1. Konfigurasi --}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route('tahun-akademik.index') }}">
          <i class="icon-paper menu-icon"></i>
          <span class="menu-title">Tahun Akademik</span>
        </a>
      </li>

      {{-- 2. Data Master --}}
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#master-data" aria-expanded="false" aria-controls="master-data">
          <i class="icon-book menu-icon"></i>
          <span class="menu-title">Data Master</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="master-data">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{ route('guru.index') }}">Guru</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('siswa.index') }}">Siswa</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('mapel.index') }}">Mata Pelajaran</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('kelas.index') }}">Kelas</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('user.index') }}">Pengguna Sistem</a></li>
          </ul>
        </div>
      </li>

      {{-- 3. Pengaturan --}}
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#pengaturan" aria-expanded="false" aria-controls="pengaturan">
          <i class="ti-settings menu-icon"></i>
          <span class="menu-title">Pengaturan</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="pengaturan">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{ route('mengajar.index') }}">Mengajar</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('pindah-kelas.index') }}">Rombongan Belajar</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('wali-kelas.index') }}">Wali Kelas</a></li>
          </ul>
        </div>
      </li>
      {{-- 4. Input Nilai --}}
      <!--
      <li class="nav-item">
        <a class="nav-link" href="{{ route('input-nilai.index') }}">
          <i class="icon-bar-graph menu-icon"></i>
          <span class="menu-title">Input Nilai</span>
        </a>
      </li>
        -->

      {{-- 5. Cetak Raport --}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.rapor.index') }}">
          <i class="icon-printer menu-icon"></i>
          <span class="menu-title">Cetak Raport</span>
        </a>
      </li>

    {{-- GURU MENU --}}
    @elseif(auth()->user()->role == 'guru')

      <li class="nav-item">
        <a class="nav-link" href="{{ route('input-nilai.index') }}">
          <i class="icon-bar-graph menu-icon"></i>
          <span class="menu-title">Input Nilai</span>
        </a>
      </li>

    {{-- WALI KELAS MENU --}}
    @if(auth()->user()->role == 'walikelas')
      <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard.walikelas') }}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      @endif

    @elseif(auth()->user()->role == 'walikelas')

      {{-- Input Nilai untuk Guru yang juga Wali Kelas --}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route('input-nilai.index') }}">
          <i class="icon-bar-graph menu-icon"></i>
          <span class="menu-title">Input Nilai</span>
        </a>
      </li>

      {{-- Input Guru + Mapel untuk Kelas --}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route('jadwal-mengajar.index') }}">
          <i class="icon-briefcase menu-icon"></i>
          <span class="menu-title">Atur Pengampu Mapel</span>
        </a>
      </li>

      {{-- Lihat Nilai dari Guru --}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route('nilai-guru.index') }}">
          <i class="icon-bar-graph menu-icon"></i>
          <span class="menu-title">Nilai dari Guru</span>
        </a>
      </li>

      {{-- Cetak Raport --}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route('rapor.index') }}">
          <i class="icon-printer menu-icon"></i>
          <span class="menu-title">Cetak Raport</span>
        </a>
      </li>

    @endif

  </ul>
</nav>
