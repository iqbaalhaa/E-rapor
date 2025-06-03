@csrf
<div class="form-group">
  <label>Tahun Ajaran</label>
  <input type="text" name="tahun" class="form-control" value="{{ old('tahun', $tahunAkademik->tahun ?? '') }}" required>
</div>
<div class="form-group">
  <label>Semester</label>
  <select name="semester" class="form-control" required>
    <option value="Ganjil" {{ (old('semester', $tahunAkademik->semester ?? '') == 'Ganjil') ? 'selected' : '' }}>Ganjil</option>
    <option value="Genap" {{ (old('semester', $tahunAkademik->semester ?? '') == 'Genap') ? 'selected' : '' }}>Genap</option>
  </select>
</div>
<div class="form-group">
  <label>Status Aktif</label>
  <select name="is_active" class="form-control">
    <option value="1" {{ (old('is_active', $tahunAkademik->is_active ?? '') == 1) ? 'selected' : '' }}>Aktif</option>
    <option value="0" {{ (old('is_active', $tahunAkademik->is_active ?? '') == 0) ? 'selected' : '' }}>Nonaktif</option>
  </select>
</div>
