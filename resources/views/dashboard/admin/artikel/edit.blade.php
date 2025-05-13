@extends('dashboard.admin.layout.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Artikel</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin.artikel.index') }}">Artikel</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.admin.artikel.update', $artikel->id_artikel) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Artikel</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ $artikel->judul }}" required>
                </div>
                <div class="mb-3">
                    <label for="isi" class="form-label">Konten</label>
                    <textarea class="form-control" id="isi" name="isi" rows="5" required>{{ $artikel->isi }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                @if($artikel->gambar)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="Gambar Artikel" style="max-width: 200px;">
                    </div>
                @endif
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="is_show" name="is_show" value="1" {{ $artikel->is_show ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_show">Tampilkan Artikel</label>
                </div>
                <button type="submit" class="btn btn-primary" dusk="update-article">Update</button>
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
