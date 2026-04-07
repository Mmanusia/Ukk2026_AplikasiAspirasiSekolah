@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div class="container py-5">
	<div class="row justify-content-center">
		<div class="col-lg-10">
			<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
				<div>
					<h1 class="h3 mb-0">Kategori Aspirasi</h1>
				</div>
				<div class="d-flex gap-2 flex-wrap">
					<a class="btn btn-primary" href="{{ route('kategori.create') }}">Tambah Kategori</a>
					<a class="btn btn-outline-secondary" href="/home">Dashboard</a>
				</div>
			</div>

			@if (session('success'))
			<div class="alert alert-success shadow-sm">{{ session('success') }}</div>
			@endif

			<div class="card border-0 shadow-sm">
				<div class="table-responsive">
					<table class="table table-hover align-middle mb-0">
						<thead class="table-light">
							<tr>
								<th style="width: 80px">#</th>
								<th>Nama Kategori</th>
								<th class="text-end" style="width: 220px">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($kategoris as $kategori)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $kategori->ket_kategori }}</td>
								<td class="text-end">
									<a class="btn btn-sm btn-outline-primary" href="{{ route('kategori.edit', $kategori) }}">Edit</a>
									<form action="{{ route('kategori.destroy', $kategori) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
									</form>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="3" class="text-center py-4 text-secondary">Belum ada kategori.</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
