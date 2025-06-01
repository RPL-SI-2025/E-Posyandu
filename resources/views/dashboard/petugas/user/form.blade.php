<input type="hidden" name="role" value="orangtua">

<div class="row g-3">
    {{-- NAMA --}}
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name ?? '') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- EMAIL --}}
    <div class="col-md-6">
        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email ?? '') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- PASSWORD --}}
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password" class="form-label">
                Password {!! isset($user) ? '<small>(Kosongkan jika tidak diubah)</small>' : '<span class="text-danger">*</span>' !!}
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

    {{-- KONFIRMASI PASSWORD --}}
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">
                Konfirmasi Password {!! isset($user) ? '' : '<span class="text-danger">*</span>' !!}
            </label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control" {{ isset($user) ? '' : 'required' }}>
            </div>
        </div>
    </div>

    {{-- TELEPON --}}
    <div class="col-md-6">
        <div class="mb-3">
            <label for="phone" class="form-label">Telepon</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                <input type="text" name="phone" id="phone"
                    class="form-control @error('phone') is-invalid @enderror"
                    value="{{ old('phone', $user->phone ?? '') }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- ALAMAT --}}
    <div class="col-12">
        <div class="mb-3">
            <label for="address" class="form-label">Alamat</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                <textarea name="address" id="address"
                    class="form-control @error('address') is-invalid @enderror"
                    rows="3">{{ old('address', $user->address ?? '') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- STATUS AKUN (VERIFIKASI) --}}
    <div class="col-md-6">
        <div class="form-group">
            <label for="status_akun" class="form-label">Status Verifikasi</label>
            <select name="status_akun" id="status_akun"
                class="form-select @error('status_akun') is-invalid @enderror" required>
                <option value="waiting" {{ old('status_akun', $user->verifikasi ?? 'waiting') == 'waiting' ? 'selected' : '' }}>Menunggu</option>
                <option value="approved" {{ old('status_akun', $user->verifikasi ?? 'waiting') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ old('status_akun', $user->verifikasi ?? 'waiting') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
            @error('status_akun')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
