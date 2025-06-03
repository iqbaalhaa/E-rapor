@csrf
<div class="form-group">
  <label>Nama</label>
  <input type="text" name="nama" class="form-control" value="{{ old('nama', $siswa->nama ?? '') }}" required>
</div>
<div class="form-group">
  <label>NIS</label>
  <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis ?? '') }}" required>
</div>
<div class="form-group">
  <label>NISN</label>
  <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn ?? '') }}">
</div>
<div class="form-group">
  <label>Email</label>
  <input type="email" name="email" class="form-control" value="{{ old('email', $siswa->email ?? '') }}">
</div>
<div class="form-group">
  <label>Jenis Kelamin</label>
  <select name="jenis_kelamin" class="form-control" required>
    <option value="">Pilih</option>
    <option value="L" {{ (old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L') ? 'selected' : '' }}>Laki-laki</option>
    <option value="P" {{ (old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P') ? 'selected' : '' }}>Perempuan</option>
  </select>
</div>
<div class="form-group">
  <label>No HP</label>
  <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $siswa->no_hp ?? '') }}">
</div>
<div class="form-group">
  <label>Kelas</label>
  <select name="kelas_id" class="form-control" required>
    <option value="">Pilih Kelas</option>
    @foreach($kelas as $item)
      <option value="{{ $item->id }}" {{ (old('kelas_id', $relasi->kelas_id ?? '') == $item->id) ? 'selected' : '' }}>
        {{ $item->nama_kelas }}
      </option>
    @endforeach
  </select>
</div>
@if(isset($tahun))
<div class="form-group">
  <label>Tahun Akademik</label>
  <input type="hidden" name="tahun_akademik_id" value="{{ $tahun->id }}">
  <input type="text" class="form-control" value="{{ $tahun->tahun }} - {{ $tahun->semester }}" readonly>
</div>
@endif
