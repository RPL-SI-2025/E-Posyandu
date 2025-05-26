@extends('dashboard.petugas.layout.app')

@section('title', 'Edit Pemeriksaan')

@section('content')
<main>
    <div class="container-fluid px-4 mt-4">
        <h3 class="mb-4">Edit Pemeriksaan Anak</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.petugas.index') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.petugas.inspection.index') }}">Pemeriksaan</a>
            </li>
            <li class="breadcrumb-item active">Edit Pemeriksaan</li>
        </ol>

        {{-- Error Validation --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Edit Pemeriksaan --}}
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard.petugas.inspection.update', $inspection->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama Anak --}}
                    <div class="mb-3">
                        <label for="table_child_id" class="form-label">Nama Anak</label>
                        <select name="table_child_id" id="table_child_id" class="form-select" required>
                            <option value="">-- Pilih Anak --</option>
                            @foreach($children as $child)
                            <option value="{{ $child->id }}" data-user-id="{{ $child->user_id }}" 
                                {{ old('table_child_id', $inspection->table_child_id) == $child->id ? 'selected' : '' }}>
                                {{ $child->nama_anak }}
                            </option>

                            @endforeach
                        </select>
                    </div>

                    {{-- Nama Orangtua (User ID) --}}
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Nama Orangtua</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">-- Pilih Orangtua --</option>
                            @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" 
                                {{ old('user_id', $inspection->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal Pemeriksaan --}}
                    <div class="mb-3">
                        <label for="tanggal_pemeriksaan" class="form-label">Tanggal Pemeriksaan</label>
                        <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" 
                               class="form-control" 
                               value="{{ old('tanggal_pemeriksaan', $inspection->tanggal_pemeriksaan->format('Y-m-d')) }}"
                               required>
                    </div>

                    {{-- Berat Badan --}}
                    <div class="mb-3">
                        <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                        <input type="number" name="berat_badan" id="berat_badan" class="form-control" 
                               step="0.01" min="0" 
                               value="{{ old('berat_badan', $inspection->berat_badan) }}" required>
                    </div>

                    {{-- Tinggi Badan --}}
                    <div class="mb-3">
                        <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi_badan" id="tinggi_badan" class="form-control" 
                               step="0.01" min="0" 
                               value="{{ old('tinggi_badan', $inspection->tinggi_badan) }}" required>
                    </div>

                    {{-- Lingkar Kepala --}}
                    <div class="mb-3">
                        <label for="lingkar_kepala" class="form-label">Lingkar Kepala (cm)</label>
                        <input type="number" name="lingkar_kepala" id="lingkar_kepala" class="form-control" 
                               step="0.01" min="0" 
                               value="{{ old('lingkar_kepala', $inspection->lingkar_kepala) }}">
                    </div>

                    {{-- Catatan --}}
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="3">{{ old('catatan', $inspection->catatan) }}</textarea>
                    </div>

                    {{-- Lokasi Penimbangan --}}
                    <div class="mb-3">
                        <label for="eventtime_id" class="form-label">Lokasi Penimbangan</label>
                        <select name="eventtime_id" id="eventtime_id" class="form-select" required>
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach($eventtimes as $event)
                                <option value="{{ $event->id }}" 
                                    {{ old('eventtime_id', $inspection->eventtime_id) == $event->id ? 'selected' : '' }}>
                                    {{ $event->lokasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('dashboard.petugas.inspection.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
{{-- Script Otomatis Isi Nama Orangtua --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const anakSelect = document.getElementById('table_child_id');
        const orangtuaSelect = document.getElementById('user_id');

        anakSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const userId = selectedOption.getAttribute('data-user-id');

            if (userId) {
                orangtuaSelect.value = userId;
            } else {
                orangtuaSelect.value = "";
            }
        });

        // Trigger sekali waktu load kalau ada old value
        anakSelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection
