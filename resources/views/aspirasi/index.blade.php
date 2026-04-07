@extends('layouts.app')

@section('title', 'Status Aspirasi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <p class="text-uppercase small text-secondary mb-1">Admin</p>
                    <h1 class="h3 mb-0">Status Aspirasi</h1>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a class="btn btn-outline-secondary" href="{{ route('home') }}">Dashboard</a>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-secondary small text-uppercase mb-1">Total Aspirasi</p>
                            <div class="display-6 fw-semibold">{{ $totalAspirasi }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-secondary small text-uppercase mb-1">Menunggu</p>
                            <div class="display-6 fw-semibold">{{ $menungguCount }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-secondary small text-uppercase mb-1">Sedang Diproses</p>
                            <div class="display-6 fw-semibold">{{ $prosesCount }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-secondary small text-uppercase mb-1">Selesai</p>
                            <div class="display-6 fw-semibold">{{ $selesaiCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap mb-4">
                <a class="btn {{ $statusFilter === 'semua' ? 'btn-dark' : 'btn-outline-dark' }}" href="{{ route('aspirasi.index') }}">
                    Semua
                    <span class="badge text-bg-light ms-1">{{ $totalAspirasi }}</span>
                </a>
                <a class="btn {{ $statusFilter === 'menunggu' ? 'btn-secondary' : 'btn-outline-secondary' }}" href="{{ route('aspirasi.index', ['status' => 'menunggu']) }}">
                    Menunggu
                    <span class="badge text-bg-light ms-1">{{ $menungguCount }}</span>
                </a>
                <a class="btn {{ $statusFilter === 'proses' ? 'btn-warning' : 'btn-outline-warning' }}" href="{{ route('aspirasi.index', ['status' => 'proses']) }}">
                    Proses
                    <span class="badge text-bg-light ms-1">{{ $prosesCount }}</span>
                </a>
                <a class="btn {{ $statusFilter === 'selesai' ? 'btn-success' : 'btn-outline-success' }}" href="{{ route('aspirasi.index', ['status' => 'selesai']) }}">
                    Selesai
                    <span class="badge text-bg-light ms-1">{{ $selesaiCount }}</span>
                </a>
            </div>

            @if (session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="row g-4">
                @forelse ($inputAspirasis as $inputAspirasi)
                @php
                    $status = $inputAspirasi->aspirasi?->status ?? 'menunggu';
                    $badgeClass = $status === 'selesai' ? 'success' : ($status === 'proses' ? 'warning' : 'secondary');
                    $fotoUrl = $inputAspirasi->foto ? asset('storage/' . $inputAspirasi->foto) : 'https://placehold.co/800x520?text=Belum+Ada+Foto';
                @endphp
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card border-1 h-100 shadow-sm">
                        <a href="{{ $inputAspirasi->aspirasi ? route('aspirasi.show', $inputAspirasi->aspirasi) : route('aspirasi.create', ['input_aspirasi_id' => $inputAspirasi->id]) }}" class="text-decoration-none text-dark">
                            <img src="{{ $fotoUrl }}" alt="Foto aspirasi {{ $inputAspirasi->lokasi }}" class="card-img-top" style="height: 220px; object-fit: cover;">
                        </a>

                        <div class="card-body">
                            <h5 class="mb-1 text-truncate">{{ $inputAspirasi->lokasi }}</h5>
                            <p class="card-text text-secondary mb-1 text-truncate">{{ $inputAspirasi->kategori?->ket_kategori ?? '-' }}</p>
                            <p class="card-text text-secondary mb-1 text-truncate">{{ $inputAspirasi->user?->name ?? '-' }}</p>
                            <span class="badge text-bg-{{ $badgeClass }}">{{ $status }}</span>
                            <p class="card-text text-secondary mb-0 mt-2 text-truncate">{{ $inputAspirasi->ket }}</p>
                        </div>

                        <div class="px-3 pb-3">
                            @if ($inputAspirasi->aspirasi)
                            <a class="btn btn-sm btn-outline-secondary w-100 mb-2" href="{{ route('aspirasi.show', $inputAspirasi->aspirasi) }}">Detail Respons</a>
                            <div class="d-flex gap-2">
                                <a class="btn btn-sm btn-outline-primary flex-fill" href="{{ route('aspirasi.edit', $inputAspirasi->aspirasi) }}">Edit</a>
                            </div>
                            @else
                            <a class="btn btn-sm btn-outline-primary w-100" href="{{ route('aspirasi.create', ['input_aspirasi_id' => $inputAspirasi->id]) }}">Buat Respons</a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-light border shadow-sm mb-0">Belum ada aspirasi siswa.</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection