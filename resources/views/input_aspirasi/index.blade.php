@extends('layouts.app')

@section('title', 'Histori Aspirasi Siswa')

@section('content')
<div class="container py-5">
	<div class="row justify-content-center">
		<div class="col-lg-12">
			<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
				<div>
					<p class="text-uppercase small text-secondary mb-1">Histori</p>
					<h1 class="h3 mb-0">Aspirasi Siswa</h1>
				</div>
				<div class="d-flex gap-2">
					<a class="btn btn-primary" href="{{ route('input_aspirasi.create') }}">Tambah Aspirasi</a>
					<a class="btn btn-outline-secondary" href="{{ route('home') }}">Dashboard</a>
				</div>
			</div>

			@if (session('success'))
			<div class="alert alert-success shadow-sm">{{ session('success') }}</div>
			@endif

			<div class="row g-3 mb-4">
				<div class="col-md-4">
					<div class="card border-0 shadow-sm h-100">
						<div class="card-body p-4">
							<div class="text-secondary">Total Laporan</div>
							<div class="display-6 fw-semibold">{{ $inputAspirasis->count() }}</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card border-0 shadow-sm h-100">
						<div class="card-body p-4">
							<div class="text-secondary">Menunggu</div>
							<div class="display-6 fw-semibold">{{ $inputAspirasis->whereNull('aspirasi_id')->count() }}</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card border-0 shadow-sm h-100">
						<div class="card-body p-4">
							<div class="text-secondary">Sedang Diproses</div>
							<div class="display-6 fw-semibold">{{ $inputAspirasis->whereNotNull('aspirasi_id')->count() }}</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card border-0 shadow-sm h-100">
						<div class="card-body p-4">
							<div class="text-secondary">Selesai</div>
							<div class="display-6 fw-semibold">{{ $inputAspirasis->where('aspirasi.status', 'selesai')->count() }}</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row g-4">
				@forelse ($inputAspirasis as $inputAspirasi)
				@php
					$status = $inputAspirasi->aspirasi?->status ?? 'menunggu';
					$badgeClass = $status === 'selesai' ? 'success' : ($status === 'proses' ? 'warning' : 'secondary');
					$fotoUrl = $inputAspirasi->foto ? asset('storage/' . $inputAspirasi->foto) : 'https://via.placeholder.com/800x520?text=Belum+Ada+Foto';
				@endphp
				<div class="col-sm-6 col-lg-4 col-xl-3">
					<div class="card border-1 h-100 shadow-sm">
						<a href="{{ route('input_aspirasi.show', $inputAspirasi) }}" class="text-decoration-none text-dark">
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
							<a href="{{ route('input_aspirasi.show', $inputAspirasi) }}" class="btn btn-sm btn-outline-primary w-100 mb-2">Detail</a>
							<div class="d-flex gap-2">
								<a href="{{ route('input_aspirasi.edit', $inputAspirasi) }}" class="btn btn-sm btn-outline-secondary flex-fill">Edit</a>
								<form action="{{ route('input_aspirasi.destroy', $inputAspirasi) }}" method="POST" class="flex-fill" onsubmit="return confirm('Hapus aspirasi ini?')">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-sm btn-outline-danger w-100">Hapus</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				@empty
				<div class="col-12">
					<div class="alert alert-light border shadow-sm mb-0">Belum ada aspirasi.</div>
				</div>
				@endforelse
			</div>
		</div>
	</div>
</div>
@endsection
