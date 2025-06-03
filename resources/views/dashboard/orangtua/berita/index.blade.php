@extends('dashboard.orangtua.layout.app')

@section('title', 'Data Bayi')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Artikel Terbaru</h1>
    <!-- Berita/Artikel Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Artikel Terbaru</h6>
        </div>
        <div class="card-body">
            @if($articles->isEmpty())
                <div class="alert alert-info">
                    Belum ada berita terbaru.
                </div>
            @else
                <div class="row">
                    @foreach($articles as $article)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <!-- Debugging Path Gambar -->
                            <!-- <p class="small text-muted">Path: {{ $article->gambar }}</p> -->
                            <!-- Tampilkan Gambar dengan Fallback -->
                            <img src="{{ $article->gambar ? asset('storage/' . $article->gambar) : asset('images/default.jpg') }}"
                                class="card-img-top"
                                alt="{{ $article->judul }}"
                                style="max-height: 200px; object-fit: cover;"
                                onerror="this.onerror=null; this.src='{{ asset('images/default.jpg') }}';">
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->judul }}</h5>
                                <p class="card-text">{{ Str::limit(strip_tags($article->isi), 100) }}</p>
                                <p class="text-muted small">Oleh: {{ $article->author }} | {{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }}</p>
                                @if(isset($article->id_artikel) && $article->id_artikel > 0)
                                    <a href="{{ route('dashboard.orangtua.berita.show', $article->id_artikel) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
