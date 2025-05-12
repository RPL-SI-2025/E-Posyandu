@extends('dashboard.admin.layout.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Artikel</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin.artikel.index') }}">Artikel</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            <h3>{{ $artikel->judul }}</h3>
            <p><strong>Tanggal:</strong> {{ $artikel->created_at->format('d-m-Y H:i') }}</p>
            <p><strong>Penulis:</strong> {{ $artikel->author }}</p>
            <p>
                <strong>Status:</strong>
                @if($artikel->is_show)
                    <span class="badge bg-success">Tampil</span>
                @else
                    <span class="badge bg-secondary">Tidak Tampil</span>
                @endif
            </p>
            <hr>
            <div>
                {!! $artikel->isi !!}
            </div>
            <a href="{{ route('dashboard.admin.artikel.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
@endsection
