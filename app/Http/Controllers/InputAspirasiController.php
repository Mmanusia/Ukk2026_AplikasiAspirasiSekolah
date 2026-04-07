<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\InputAspirasi;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

// Logika Input Aspirasi
class InputAspirasiController extends Controller
{
    // Logika untuk menampilkan semua aspirasi siswa
    public function index(): View
    {
        $user = auth()->user();
        $query = InputAspirasi::with(['user', 'kategori', 'aspirasi'])
            ->orderByDesc('tanggal_aspirasi')
            ->orderByDesc('id');

        if ($user?->role === 'siswa') {
            $query->where('user_id', $user->id);
        }

        $inputAspirasis = $query->get();

        return view('input_aspirasi.index', compact('inputAspirasis'));
    }

    // Logika untuk menampilkan form tambah aspirasi
    public function create(): View
    {
        $kategoris = Kategori::orderBy('ket_kategori')->get();

        return view('input_aspirasi.create', compact('kategoris'));
    }

    // Logika untuk menyimpan aspirasi
    public function store(Request $request)
    {
        $this->ensureRole($request, 'siswa');

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi' => 'required|string|max:255',
            'ket' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tanggal_aspirasi' => 'nullable|date',
        ]);

        $validated['user_id'] = $request->user()->id;
        $validated['tanggal_aspirasi'] = $validated['tanggal_aspirasi'] ?? now()->toDateString();
        $validated['aspirasi_id'] = null;

        // Lokasi penyimpanan foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('input-aspirasi', 'public');
        }

        InputAspirasi::create($validated);

        return redirect()->route('input_aspirasi.index')->with('success', 'Aspirasi Berhasil Ditambah');
    }

    // Logika untuk menampilkan detail aspirasi
    public function show(InputAspirasi $input_aspirasi): View
    {
        $this->ensureOwnershipForUser(request(), $input_aspirasi);
        $input_aspirasi->load(['user', 'kategori', 'aspirasi']);

        return view('input_aspirasi.detail', compact('input_aspirasi'));
    }

    // Logika untuk menampilkan form edit aspirasi
    public function edit(InputAspirasi $input_aspirasi): View
    {
        $this->ensureOwnershipForUser(request(), $input_aspirasi);
        $kategoris = Kategori::orderBy('ket_kategori')->get();

        return view('input_aspirasi.edit', compact('input_aspirasi', 'kategoris'));
    }

    // Logika untuk mengupdate aspirasi yang dipilih
    public function update(Request $request, InputAspirasi $input_aspirasi)
    {
        $this->ensureRole($request, 'siswa');
        $this->ensureOwnershipForUser($request, $input_aspirasi);

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi' => 'required|string|max:255',
            'ket' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tanggal_aspirasi' => 'required|date',
        ]);

        $validated['user_id'] = $request->user()->id;

        if ($request->hasFile('foto')) {
            if ($input_aspirasi->foto) {
                Storage::disk('public')->delete($input_aspirasi->foto);
            }

            $validated['foto'] = $request->file('foto')->store('input-aspirasi', 'public');
        }

        $input_aspirasi->update($validated);

        return redirect()->route('input_aspirasi.index')->with('success', 'Aspirasi Berhasil Diupdate');
    }

    // Logika untuk menghapus aspirasi yang dipilih
    public function destroy(InputAspirasi $input_aspirasi)
    {
        $this->ensureRole(request(), 'siswa');
        $this->ensureOwnershipForUser(request(), $input_aspirasi);

        if ($input_aspirasi->foto) {
            Storage::disk('public')->delete($input_aspirasi->foto);
        }

        $input_aspirasi->delete();

        return redirect()->route('input_aspirasi.index')->with('success', 'Aspirasi Berhasil Dihapus');
    }

    // Logika untuk memastikan user memiliki role tertentu
    private function ensureRole(Request $request, string $role): void
    {
        if ($request->user()?->role !== $role) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    // Logika untuk memastikan user hanya bisa mengakses aspirasi miliknya sendiri
    private function ensureOwnershipForUser(Request $request, InputAspirasi $inputAspirasi): void
    {
        $user = $request->user();

        if ($user?->role === 'siswa') {
            if ($inputAspirasi->user_id !== $user->id) {
                abort(403, 'Anda hanya bisa mengakses aspirasi milik sendiri.');
            }
        }
    }
}