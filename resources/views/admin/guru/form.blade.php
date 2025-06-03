@csrf
<div class="form-group">
  <label>Nama</label>
  <input type="text" name="nama" class="form-control" value="{{ old('nama', $guru->nama ?? '') }}" required>
</div>
<div class="form-group">
  <label>NIP</label>
  <input type="text" name="nip" class="form-control" value="{{ old('nip', $guru->nip ?? '') }}" required>
</div>
<div class="form-group">
  <label>Email</label>
  <input type="email" name="email" class="form-control" value="{{ old('email', $guru->email ?? '') }}" required>
</div>
