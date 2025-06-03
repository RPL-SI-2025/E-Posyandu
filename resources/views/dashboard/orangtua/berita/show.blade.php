@extends('dashboard.orangtua.layout.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">{{ $article->judul }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.orangtua.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.orangtua.berita.index') }}">Artikel Terbaru</a></li>
        <li class="breadcrumb-item active">{{ $article->judul }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-newspaper mr-1"></i>
            Detail Berita
        </div>
        <div class="card-body">
            <h3>{{ $article->judul }}</h3>
            <p class="text-muted">Diposting pada: {{ $article->created_at->format('d M Y') }}</p>

            @if($article->gambar)
                <div class="mb-4 text-center">
                    <img src="{{ asset('storage/' . $article->gambar) }}"
                        alt="{{ $article->judul }}"
                        style="max-width: 100%; max-height: 300px; height: auto;"
                        onerror="this.onerror=null; this.src='{{ asset('images/default.jpg') }}';">
                </div>
            @endif

            <div>
                {!! $article->isi !!}
            </div>
            <a href="{{ route('dashboard.orangtua.berita.index') }}" class="btn btn-primary mt-3">Kembali ke Berita</a>
        </div>
    </div>
</div>
@endsection
