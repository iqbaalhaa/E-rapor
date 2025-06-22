@extends('layouts.main')

@section('title', 'Edit Profil')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="ti-user text-primary"></i> Edit Profil
                </h4>
                
                <div class="alert alert-info">
                    <i class="ti-info"></i> 
                    <strong>Informasi:</strong> Anda dapat mengubah informasi profil Anda di sini. 
                    Perubahan akan langsung tersimpan setelah Anda menekan tombol "Simpan Perubahan".
                    @if($user->role === 'guru' || $user->role === 'walikelas')
                        <br><small>Untuk guru dan wali kelas, Anda juga dapat mengisi NIP Anda.</small>
                    @endif
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti-check"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ti-alert"></i> Terdapat kesalahan dalam form:
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><i class="ti-image"></i> Foto Profil</label>
                                <div class="text-center mb-3">
                                    <img id="preview-photo" src="{{ $user->photo_url }}" 
                                         alt="Foto Profil" 
                                         class="rounded-circle shadow" 
                                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #ddd;">
                                </div>
                                <input type="file" name="photo" id="photo" class="form-control-file @error('photo') is-invalid @enderror" accept="image/*">
                                <small class="form-text text-muted">
                                    <i class="ti-info"></i> Format: JPG, PNG, GIF. Maksimal 2MB.
                                </small>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="name"><i class="ti-user"></i> Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email"><i class="ti-email"></i> Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($user->role === 'guru' || $user->role === 'walikelas')
                                <div class="form-group">
                                    <label for="nip"><i class="ti-id-badge"></i> NIP</label>
                                    <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" 
                                           value="{{ old('nip', $guru->nip ?? '') }}" placeholder="Masukkan NIP (hanya angka)">
                                    <small class="form-text text-muted">
                                        <i class="ti-info"></i> NIP bersifat opsional untuk guru/wali kelas. 
                                        Jika belum memiliki NIP, biarkan kosong. NIP hanya boleh berisi angka.
                                    </small>
                                    @error('nip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="role"><i class="ti-shield"></i> Role</label>
                                <input type="text" class="form-control bg-light" value="{{ ucfirst($user->role) }}" readonly>
                                <small class="form-text text-muted">
                                    <i class="ti-info"></i> 
                                    @if($user->role === 'admin')
                                        Anda adalah administrator sistem
                                    @elseif($user->role === 'guru')
                                        Anda adalah guru mata pelajaran
                                    @elseif($user->role === 'walikelas')
                                        Anda adalah wali kelas
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5><i class="ti-lock text-warning"></i> Ubah Password</h5>
                    <p class="text-muted">
                        <i class="ti-info"></i> Kosongkan jika tidak ingin mengubah password
                    </p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current_password"><i class="ti-key"></i> Password Saat Ini</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="new_password"><i class="ti-key"></i> Password Baru</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="new_password_confirmation"><i class="ti-key"></i> Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="ti-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="ti-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photo');
    const previewPhoto = document.getElementById('preview-photo');
    
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validasi ukuran file
            if (file.size > 2 * 1024 * 1024) { // 2MB
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewPhoto.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush 