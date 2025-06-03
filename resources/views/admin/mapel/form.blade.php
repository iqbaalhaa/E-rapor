@csrf
<div class="form-group">
  <label>Kode Mapel</label>
  <input type="text" name="kode" class="form-control" value="{{ old('kode', $mapel->kode ?? '') }}" required>
</div>
<div class="form-group">
  <label>Nama</label>
  <input type="text" name="nama" class="form-control" value="{{ old('nama', $mapel->nama ?? '') }}" required>
</div>
<div class="form-group">
  <label>Jenis</label>
  <select name="jenis" class="form-control">
    <option value="Wajib" {{ (old('jenis', $mapel->jenis ?? '') == 'Wajib') ? 'selected' : '' }}>Wajib</option>
    <option value="Muatan Lokal" {{ (old('jenis', $mapel->jenis ?? '') == 'Muatan Lokal') ? 'selected' : '' }}>Muatan Lokal</option>
    <option value="Tambahan" {{ (old('jenis', $mapel->jenis ?? '') == 'Tambahan') ? 'selected' : '' }}>Tambahan</option>
  </select>
</div>
<div class="form-group">
  <label>KKM</label>
  <input type="number" name="kkm" class="form-control" value="{{ old('kkm', $mapel->kkm ?? 75) }}" required>
</div>
