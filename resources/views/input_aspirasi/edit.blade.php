@extends('layouts.app')

@section('title', 'Edit Aspirasi Siswa')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-uppercase small text-secondary mb-1">Histori</p>
                    <h1 class="h3 mb-0">Edit Aspirasi</h1>
                </div>
                <a class="btn btn-outline-secondary" href="{{ route('input_aspirasi.index') }}">Kembali</a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('input_aspirasi.update', $input_aspirasi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label" for="kategori_id">Kategori</label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id">
                                @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori_id', $input_aspirasi->kategori_id) == $kategori->id)>{{ $kategori->ket_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="lokasi">Lokasi</label>
                            <input class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" type="text" name="lokasi" value="{{ old('lokasi', $input_aspirasi->lokasi) }}">
                            @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="ket">Isi Aspirasi</label>
                            <textarea class="form-control @error('ket') is-invalid @enderror" id="ket" name="ket" rows="5">{{ old('ket', $input_aspirasi->ket) }}</textarea>
                            @error('ket')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Saat Ini</label>
                            <div class="mb-2">
                                @if ($input_aspirasi->foto)
                                <img src="{{ asset('storage/' . $input_aspirasi->foto) }}" alt="Foto aspirasi" class="img-fluid rounded border" style="max-height: 220px; object-fit: cover;">
                                @else
                                <div class="border rounded bg-light p-4 text-secondary">Belum ada foto</div>
                                @endif
                            </div>
                            <label class="form-label" for="foto">Ganti Foto Pendukung</label>
                            <input class="form-control @error('foto') is-invalid @enderror" id="foto" type="file" name="foto" accept="image/*">
                            <div class="form-text">Kosongkan jika tidak ingin mengganti foto.</div>
                            @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="tanggal_aspirasi">Tanggal Laporan</label>
                            <input class="form-control @error('tanggal_aspirasi') is-invalid @enderror" id="tanggal_aspirasi" type="date" name="tanggal_aspirasi" value="{{ old('tanggal_aspirasi', optional($input_aspirasi->tanggal_aspirasi)->format('Y-m-d')) }}">
                            @error('tanggal_aspirasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">Perbarui Aspirasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection