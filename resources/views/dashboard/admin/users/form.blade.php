<div class="row g-3">
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $user->name ?? '') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email', $user->email ?? '') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password" class="form-label">
                Password {{ isset($user) ? '(Kosongkan jika tidak ingin mengubah)' : '<span class="text-danger">*</span>' }}
            </label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-key"></i></span>
                <input type="password" name="password" id="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       {{ isset($user) ? '' : 'required' }}>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">
                Konfirmasi Password {{ isset($user) ? '' : '<span class="text-danger">*</span>' }}
            </label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                       class="form-control" {{ isset($user) ? '' : 'required' }}>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">Pilih Role</option>
                    @foreach(['admin', 'petugas', 'orangtua'] as $role)
                        <option value="{{ $role }}" {{ old('role', $user->role ?? '') === $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="mb-3">
            <label for="phone" class="form-label">Telepon</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                       value="{{ old('phone', $user->phone ?? '') }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    
    <div class="col-12">
        <div class="mb-3">
            <label for="address" class="form-label">Alamat</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" 
                          rows="3">{{ old('address', $user->address ?? '') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>