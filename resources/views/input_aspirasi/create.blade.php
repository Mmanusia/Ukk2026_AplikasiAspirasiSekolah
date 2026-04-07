@extends('layouts.app')

@section('title', 'Form Aspirasi Siswa')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-uppercase small text-secondary mb-1">Form Aspirasi</p>
                    <h1 class="h3 mb-0">Sampaikan Pengaduan</h1>
                </div>
                <a class="btn btn-outline-secondary" href="{{ route('input_aspirasi.index') }}">Histori</a>
            </div>

            @if (session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('input_aspirasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="kategori_id">Kategori</label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id">
                                <option value="" hidden>Pilih kategori</option>
                                @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori_id') == $kategori->id)>{{ $kategori->ket_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="lokasi">Lokasi</label>
                            <input class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Ruang kelas RPL">
                            @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="ket">Isi Aspirasi</label>
                            <textarea class="form-control @error('ket') is-invalid @enderror" id="ket" name="ket" rows="5" placeholder="Tulis keluhan atau masukan kamu">{{ old('ket') }}</textarea>
                            @error('ket')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="foto">Foto Pendukung</label>
                            <input class="form-control @error('foto') is-invalid @enderror" id="foto" type="file" name="foto" accept="image/*">
                            <div class="form-text">Format: JPG, PNG, WEBP. Ukuran maksimal 2 MB.</div>
                            @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="tanggal_aspirasi">Tanggal Laporan</label>
                            <input class="form-control @error('tanggal_aspirasi') is-invalid @enderror" id="tanggal_aspirasi" type="date" name="tanggal_aspirasi" value="{{ old('tanggal_aspirasi', date('Y-m-d')) }}">
                            @error('tanggal_aspirasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">Kirim Aspirasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
