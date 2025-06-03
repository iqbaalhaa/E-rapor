@csrf
<div class="form-group">
  <label>Nama Kelas</label>
  <input type="text" name="nama_kelas" class="form-control" value="{{ old('nama_kelas', $kelas->nama_kelas ?? '') }}" required>
</div>
