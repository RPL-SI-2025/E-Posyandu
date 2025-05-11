@extends('dashboard.admin.layout.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Artikel</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin.artikel.index') }}">Artikel</a></li>
        <li class="breadcrumb-item active">Tambah Artikel</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Artikel</label>
                    <input type="text" class="form-control" id="judul" name="judul" required>
                </div>
                <div class="mb-3">
                    <label for="isi" class="form-label">Konten</label>
                    <textarea class="form-control" id="isi" name="isi" rows="5" required>{{ old('isi', isset($artikel) ? $artikel->isi : '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="is_show" name="is_show" value="1" checked>
                    <label class="form-check-label" for="is_show">Tampilkan Artikel</label>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('dashboard.admin.artikel.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#isi'))
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
