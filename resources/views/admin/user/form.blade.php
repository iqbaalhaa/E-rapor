@csrf
<div class="form-group">
  <label>Email</label>
  <input type="text" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
</div>

<div class="form-group">
  <label>Nama</label>
  <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
</div>

<div class="form-group">
  <label>Role</label>
  <select name="role" class="form-control" required>
    <option value="">Pilih Role</option>
    <option value="admin" {{ (old('role', $user->role ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
    <option value="guru" {{ (old('role', $user->role ?? '') == 'guru') ? 'selected' : '' }}>Guru</option>
    <option value="walikelas" {{ (old('role', $user->role ?? '') == 'walikelas') ? 'selected' : '' }}>Wali Kelas</option>
  </select>
</div>

<div class="form-group">
  <label>Password {{ isset($user) ? '(kosongkan jika tidak ganti)' : '' }}</label>
  <input type="password" name="password" class="form-control">
</div>
