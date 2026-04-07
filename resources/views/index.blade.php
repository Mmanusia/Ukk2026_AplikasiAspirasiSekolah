@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <p class="text-uppercase small text-secondary mb-1">Pengaduan Sarana Sekolah</p>
                    <h1 class="mb-0">Menu Utama</h1>
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

            @if (session('success'))
            <div class="alert alert-success shadow-sm" role="alert">
                {{ session('success') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger shadow-sm" role="alert">
                <p class="fw-semibold mb-2">Data belum valid:</p>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="row g-3 mb-4">
                @if (auth()->user()?->role === 'siswa')
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <p class="text-secondary mb-1">Form Aspirasi</p>
                            <h5 class="mb-3">Kirim keluhan sarana atau prasarana</h5>
                            <a class="btn btn-primary btn-sm" href="{{ route('input_aspirasi.create') }}">Buat Aspirasi</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <p class="text-secondary mb-1">Histori Aspirasi</p>
                            <h5 class="mb-3">Lihat progres dan umpan balik</h5>
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('input_aspirasi.index') }}">Lihat Histori</a>
                        </div>
                    </div>
                </div>
                @endif

                @if (auth()->user()?->role === 'admin')
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <p class="text-secondary mb-1">Manajemen Aspirasi</p>
                            <h5 class="mb-3">Tindak lanjuti laporan siswa</h5>
                            <a class="btn btn-outline-secondary btn-sm" href="{{ route('aspirasi.index') }}">Lihat Status</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <p class="text-secondary mb-1">Data Kategori</p>
                            <h5 class="mb-3">Tambah dan ubah kategori pengaduan</h5>
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('kategori.index') }}">Kelola Kategori</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="h4 mb-1">Aspirasi Sekolah</h2>
                            <p class="text-secondary mb-0">Gunakan menu di atas untuk mengirim, memantau, dan menindaklanjuti laporan.</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        @if (auth()->user()?->role === 'siswa')
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light">
                                <div class="small text-secondary">Alur Siswa</div>
                                <div class="fw-semibold">Isi laporan, pilih kategori, lalu pantau histori.</div>
                            </div>
                        </div>
                        @endif
                        @if (auth()->user()?->role === 'admin')
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light">
                                <div class="small text-secondary">Alur Admin</div>
                                <div class="fw-semibold">Berikan status, feedback, dan tutup laporan saat selesai.</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection