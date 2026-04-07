<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Aspirasi;
use App\Models\InputAspirasi;

class AspirasiController extends Controller
{
    // Logika untuk menampilkan semua aspirasi
    public function index(Request $request): View
    {
        // Logika untuk menampilkan semua aspirasi dengan filter status
        $allowedStatuses = ['menunggu', 'proses', 'selesai'];
        $statusFilter = $request->query('status', 'semua');

        // Validasi status filter
        if (! in_array($statusFilter, $allowedStatuses, true)) {
            $statusFilter = 'semua';
        }

        $inputAspirasisQuery = InputAspirasi::with(['user', 'kategori', 'aspirasi'])
            ->orderByDesc('tanggal_aspirasi')
            ->orderByDesc('id');

        if ($statusFilter === 'menunggu') {
            $inputAspirasisQuery->whereNull('aspirasi_id');
        } elseif ($statusFilter === 'proses' || $statusFilter === 'selesai') {
            $inputAspirasisQuery->whereHas('aspirasi', function ($query) use ($statusFilter) {
                $query->where('status', $statusFilter);
            });
        }

        $inputAspirasis = $inputAspirasisQuery->get();

        $totalAspirasi = InputAspirasi::count();
        $menungguCount = InputAspirasi::whereNull('aspirasi_id')->count();
        $prosesCount = InputAspirasi::whereHas('aspirasi', function ($query) {
            $query->where('status', 'proses');
        })->count();
        $selesaiCount = InputAspirasi::whereHas('aspirasi', function ($query) {
            $query->where('status', 'selesai');
        })->count();

        return view('aspirasi.index', compact(
            'inputAspirasis',
            'statusFilter',
            'totalAspirasi',
            'menungguCount',
            'prosesCount',
            'selesaiCount',
        ));
    }

    // Logika untuk menampilkan form tambah aspirasi
    public function create(Request $request): View
    {
        $inputAspirasis = InputAspirasi::with(['user', 'kategori'])
            ->whereNull('aspirasi_id')
            ->orderByDesc('tanggal_aspirasi')
            ->get();
        $selectedInputAspirasiId = $request->integer('input_aspirasi_id');

        return view('aspirasi.create', compact('inputAspirasis', 'selectedInputAspirasiId'));
    }

    // Logika untuk menyimpan aspirasi
    public function store(Request $request)
    {
        $validated = $request->validate([
            'input_aspirasi_id' => 'required|exists:input_aspirasis,id',
            'status' => 'required|in:menunggu,proses,selesai',
            'feedback' => 'required|string|max:1000',
            'tanggal_dibuat' => 'nullable|date',
        ]);

        $inputAspirasi = InputAspirasi::with('kategori')->findOrFail($validated['input_aspirasi_id']);
        $validated['kategori_id'] = $inputAspirasi->kategori_id;
        $inputAspirasiId = $validated['input_aspirasi_id'];
        unset($validated['input_aspirasi_id']);
        $validated['tanggal_dibuat'] = $validated['tanggal_dibuat'] ?? now()->toDateString();

        $aspirasi = Aspirasi::create($validated);

        InputAspirasi::whereKey($inputAspirasiId)->update([
            'aspirasi_id' => $aspirasi->id,
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi Berhasil Ditambah');
    }

    // Logika untuk menampilkan detail aspirasi
    public function show(Aspirasi $aspirasi): View
    {
        $aspirasi->load(['kategori', 'inputAspirasi.user', 'inputAspirasi.kategori']);

        return view('aspirasi.detail', compact('aspirasi'));
    }

    // Logika untuk menampilkan form edit aspirasi
    public function edit(Aspirasi $aspirasi): View
    {
        $inputAspirasis = InputAspirasi::with(['user', 'kategori'])
            ->orderByDesc('tanggal_aspirasi')
            ->get();

        return view('aspirasi.edit', compact('aspirasi', 'inputAspirasis'));
    }

    // Logika untuk mengupdate aspirasi yang dipilih
    public function update(Request $request, Aspirasi $aspirasi)
    {
        $validated = $request->validate([
            'input_aspirasi_id' => 'required|exists:input_aspirasis,id',
            'status' => 'required|in:menunggu,proses,selesai',
            'feedback' => 'required|string|max:1000',
            'tanggal_dibuat' => 'required|date',
        ]);

        $inputAspirasi = InputAspirasi::with('kategori')->findOrFail($validated['input_aspirasi_id']);
        $validated['kategori_id'] = $inputAspirasi->kategori_id;
        $inputAspirasiId = $validated['input_aspirasi_id'];
        unset($validated['input_aspirasi_id']);

        if ($aspirasi->inputAspirasi && $aspirasi->inputAspirasi->id !== (int) $inputAspirasiId) {
            $aspirasi->inputAspirasi->update(['aspirasi_id' => null]);
        }

        $aspirasi->update($validated);

        InputAspirasi::whereKey($inputAspirasiId)->update([
            'aspirasi_id' => $aspirasi->id,
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi Berhasil Diupdate');
    }

    // Logika untuk menghapus aspirasi yang di pilih
    public function destroy(Aspirasi $aspirasi)
    {
        if ($aspirasi->inputAspirasi) {
            $aspirasi->inputAspirasi->update(['aspirasi_id' => null]);
        }

        $aspirasi->delete();

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi Berhasil Dihapus');
    }
}