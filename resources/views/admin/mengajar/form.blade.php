@csrf
<div class="form-group">
  <label>Guru</label>
  <select name="guru_id" class="form-control" required>
    <option value="">-- Pilih Guru --</option>
    @foreach($guru as $item)
    <option value="{{ $item->id }}" {{ old('guru_id', $mengajar->guru_id ?? '') == $item->id ? 'selected' : '' }}>
      {{ $item->nama }}
    </option>
    @endforeach
  </select>
</div>

<div class="form-group">
  <label>Mata Pelajaran</label>
  <select name="mapel_id" class="form-control" required>
    <option value="">-- Pilih Mapel --</option>
    @foreach($mapel as $item)
    <option value="{{ $item->id }}" {{ old('mapel_id', $mengajar->mapel_id ?? '') == $item->id ? 'selected' : '' }}>
      {{ $item->nama }}
    </option>
    @endforeach
  </select>
</div>

<div class="form-group">
  <label>Kelas</label>
  <select name="kelas_id" class="form-control" required>
    <option value="">-- Pilih Kelas --</option>
    @foreach($kelas as $item)
    <option value="{{ $item->id }}" {{ old('kelas_id', $mengajar->kelas_id ?? '') == $item->id ? 'selected' : '' }}>
      {{ $item->nama_kelas }}
    </option>
    @endforeach
  </select>
</div>

<div class="form-group">
  <label>Tahun Akademik</label>
  <input type="hidden" name="tahun_akademik_id" value="{{ $tahun->id }}">
  <input type="text" class="form-control" value="{{ $tahun->tahun }}" readonly>
</div>
