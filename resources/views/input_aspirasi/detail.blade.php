@extends('layouts.app')

@section('title', 'Detail Aspirasi Siswa')
@section('content')
<div class="container py-5">
	<div class="row justify-content-center">
		<div class="col-lg-8">
			<div class="d-flex justify-content-between align-items-center mb-4">
				<div>
					<p class="text-uppercase small text-secondary mb-1">Histori</p>
					<h1 class="h3 mb-0">Detail Aspirasi</h1>
				</div>
				<a class="btn btn-outline-secondary" href="{{ route('input_aspirasi.index') }}">Kembali</a>
			</div>

			<div class="card border-0 shadow-sm mb-4">
				@if ($input_aspirasi->foto)
				<img src="{{ asset('storage/' . $input_aspirasi->foto) }}" alt="Foto aspirasi" class="card-img-top" style="max-height: 360px; object-fit: cover;">
				@else
				<div class="bg-light d-flex align-items-center justify-content-center" style="height: 260px;">
					<span class="text-secondary">Belum ada foto</span>
				</div>
				@endif

				<div class="card-body p-4">
					<div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-3">
						<div>
							<h2 class="h4 mb-1">{{ $input_aspirasi->lokasi }}</h2>
							<p class="text-secondary mb-0">{{ $input_aspirasi->kategori?->ket_kategori ?? '-' }} - {{ optional($input_aspirasi->tanggal_aspirasi)->format('d M Y') ?? '-' }}</p>
						</div>
						<span class="badge text-bg-{{ $input_aspirasi->aspirasi ? ($input_aspirasi->aspirasi->status === 'selesai' ? 'success' : ($input_aspirasi->aspirasi->status === 'proses' ? 'warning' : 'secondary')) : 'secondary' }} align-self-start">
							{{ $input_aspirasi->aspirasi?->status ?? 'menunggu' }}
						</span>
					</div>
					<p class="mb-4">{{ $input_aspirasi->ket }}</p>

					<dl class="row mb-0">
						<dt class="col-sm-4">Pelapor</dt>
						<dd class="col-sm-8">{{ $input_aspirasi->user?->name ?? '-' }}</dd>

						<dt class="col-sm-4">Email</dt>
						<dd class="col-sm-8">{{ $input_aspirasi->user?->email ?? '-' }}</dd>

						<dt class="col-sm-4">Feedback</dt>
						<dd class="col-sm-8">{{ $input_aspirasi->aspirasi?->feedback ?? 'Belum ada feedback' }}</dd>
					</dl>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection