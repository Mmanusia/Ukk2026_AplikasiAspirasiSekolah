@extends('layouts.app')

@section('title', 'Foto Galeri')

@section('content')
<div class="container py-4 py-md-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1>Foto Galeri</h1>
        </div>

        <div class="d-flex gap-2">
            @auth
            <a href="{{ route('logout') }}" class="btn btn-outline-danger"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            @else
            @if (Route::has('login'))
            <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
            @endif
            @endauth
        </div>
    </div>

    <div class="row g-3">
        <div class="border rounded-3 p-3">
            <p>Total Foto</p>
            <p class="fs-4 fw-semibold mb-0">{{ $fotos->count() }}</p>
        </div>
        <div class="border rounded-3 p-3">
            <p>Total Album</p>
            <p class="fs-4 fw-semibold mb-0">{{ $fotos->pluck('AlbumID')->unique()->count() }}</p>
        </div>
        <div class="border rounded-3 p-3">
            <p>Album Baru</p>
            @auth
            <a class="btn btn-primary btn-sm mt-2" href="/tambahAlbum">Tambah Album</a>
            @else
            <p>Login untuk menambah album.</p>
            @endauth
        </div>
        <div class="border rounded-3 p-3">
            <p>Upload Foto</p>
            @auth
            <a class="btn btn-dark btn-sm mt-2" href="/tambah">Tambah Foto</a>
            @else
            <p class="small text-secondary mb-0 mt-2">Guest hanya bisa melihat galeri.</p>
            @endauth
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success shadow-sm" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger shadow-sm" role="alert">
        <p class="fw-semibold mb-2">Data upload belum valid:</p>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <h2 class="h4 mb-1">Galeri Foto</h2>
    <p class="text-secondary mb-0">Semua foto terbaru tampil di bawah ini.</p>

    <div class="row g-4">
        @forelse ($fotos as $foto)
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="card border-1">
                <a href="{{ route('foto.detail', $foto) }}" class="text-decoration-none text-dark">
                    <img src="{{ asset($foto->LokasiFile) }}" alt="{{ $foto->JudulFoto }}" class="card-img-top"
                        style="height: 220px; object-fit: cover;">
                </a>

                <div class="card-body">
                    <h5>{{ $foto->JudulFoto }}</h5>
                    <p class="card-text text-secondary mb-0">{{ $foto->likes_count }} Like</p>
                </div>

                @auth
                @if (auth()->user()->isAdmin())
                <form action="{{ route('foto.destroy', $foto) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus foto ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                        Hapus Foto
                    </button>
                </form>
                @endif
                @endauth
            </div>
        </div>
        @empty
        <h5>Belum ada foto</h5>
        <p class="text-secondary mb-0">Silakan tambahkan foto baru untuk mulai mengisi galeri.</p>
        @endforelse
    </div>
</div>
@endsection