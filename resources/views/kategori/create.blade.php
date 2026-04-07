@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Tambah Kategori</h1>
                </div>
                <a class="btn btn-outline-secondary" href="{{ route('kategori.index') }}">Kembali</a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('kategori.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="ket_kategori">Nama Kategori</label>
                            <input class="form-control @error('ket_kategori') is-invalid @enderror" id="ket_kategori" type="text" name="ket_kategori" value="{{ old('ket_kategori') }}" placeholder="Contoh: Fasilitas Kelas">
                            @error('ket_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">Simpan Kategori</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection