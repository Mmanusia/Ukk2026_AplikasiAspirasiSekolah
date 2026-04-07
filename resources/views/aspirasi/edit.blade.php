@extends('layouts.app')

@section('title', 'Edit Respons Aspirasi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-uppercase small text-secondary mb-1">Admin</p>
                    <h1 class="h3 mb-0">Edit Respons Aspirasi</h1>
                </div>
                <a class="btn btn-outline-secondary" href="{{ route('aspirasi.index') }}">Kembali</a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @php
                        $selectedInput = $inputAspirasis->firstWhere('id', old('input_aspirasi_id', $aspirasi->inputAspirasi?->id));
                    @endphp
                    <form action="{{ route('aspirasi.update', $aspirasi) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label" for="input_aspirasi_id">Pilih Aspirasi</label>
                            <input type="hidden" name="input_aspirasi_id" value="{{ $selectedInput?->id }}">
                            <input class="form-control @error('input_aspirasi_id') is-invalid @enderror" type="text" value="{{ $selectedInput ? ($selectedInput->user?->name ?? 'User') . ' - ' . $selectedInput->lokasi : 'Pilih aspirasi terlebih dahulu' }}" readonly>
                            @error('input_aspirasi_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Aspirasi</label>
                            <div class="border rounded overflow-hidden bg-light" style="min-height: 220px;">
                                <img
                                    src="{{ $selectedInput?->foto ? asset('storage/' . $selectedInput->foto) : 'https://placehold.co/900x520?text=Belum+Ada+Foto' }}"
                                    alt="Foto aspirasi"
                                    class="w-100"
                                    style="max-height: 320px; object-fit: cover;"
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori yang dipilih</label>
                            <input class="form-control" id="kategori_display" type="text" value="{{ $selectedInput?->kategori?->ket_kategori ?? '-' }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="menunggu" @selected(old('status', $aspirasi->status) === 'menunggu')>Menunggu</option>
                                <option value="proses" @selected(old('status', $aspirasi->status) === 'proses')>Proses</option>
                                <option value="selesai" @selected(old('status', $aspirasi->status) === 'selesai')>Selesai</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="feedback">Feedback</label>
                            <textarea class="form-control @error('feedback') is-invalid @enderror" id="feedback" name="feedback" rows="5">{{ old('feedback', $aspirasi->feedback) }}</textarea>
                            @error('feedback')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="tanggal_dibuat">Tanggal Respons</label>
                            <input class="form-control @error('tanggal_dibuat') is-invalid @enderror" id="tanggal_dibuat" type="date" name="tanggal_dibuat" value="{{ old('tanggal_dibuat', optional($aspirasi->tanggal_dibuat)->format('Y-m-d')) }}">
                            @error('tanggal_dibuat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">Perbarui Respons</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection