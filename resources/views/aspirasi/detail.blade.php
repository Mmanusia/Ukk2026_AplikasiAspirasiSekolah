@extends('layouts.app')

@section('title', 'Detail Respons Aspirasi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-uppercase small text-secondary mb-1">Admin</p>
                    <h1 class="h3 mb-0">Detail Respons</h1>
                </div>
                <a class="btn btn-outline-secondary" href="{{ route('aspirasi.index') }}">Kembali</a>
            </div>

            <div class="card border-0 shadow-sm">
                <img
                    src="{{ $aspirasi->inputAspirasi?->foto ? asset('storage/' . $aspirasi->inputAspirasi->foto) : 'https://placehold.co/900x520?text=Belum+Ada+Foto' }}"
                    alt="Foto aspirasi"
                    class="card-img-top"
                    style="max-height: 360px; object-fit: cover;"
                >
                <div class="card-body p-4">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Tanggal Respons</dt>
                        <dd class="col-sm-8">{{ optional($aspirasi->tanggal_dibuat)->format('d M Y') ?? '-' }}</dd>

                        <dt class="col-sm-4">Kategori</dt>
                        <dd class="col-sm-8">{{ $aspirasi->kategori?->ket_kategori ?? '-' }}</dd>

                        <dt class="col-sm-4">Pelapor</dt>
                        <dd class="col-sm-8">{{ $aspirasi->inputAspirasi?->user?->name ?? '-' }}</dd>

                        <dt class="col-sm-4">Lokasi</dt>
                        <dd class="col-sm-8">{{ $aspirasi->inputAspirasi?->lokasi ?? '-' }}</dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">{{ $aspirasi->status }}</dd>

                        <dt class="col-sm-4">Feedback</dt>
                        <dd class="col-sm-8">{{ $aspirasi->feedback }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection