<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Kategori;

// Logika Untuk Katefori
class KategoriController extends Controller
{
    // Logika untuk menampilkan semua kategori
    public function index(): View
    {
        $kategoris = Kategori::all();
        return view('kategori.index', compact('kategoris'));
    }

    // Untuk menampilkan form tambah kategori
    public function create(): View
    {
        return view('kategori.create');
    }

    // Untuk menyimpan kategori
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ket_kategori' => 'required|string|max:255',
        ]);

        Kategori::create($validated);

        return redirect()->route('kategori.index')->with('success', 'kategori Berhasil Ditambah');
    }

    // Untuk menampilkan form edit kategori
    public function edit(Kategori $kategori): View
    {
        return view('kategori.edit', compact('kategori'));
    }

    // Untuk mengupdate kategori yang dipilih
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'ket_kategori' => 'required|string|max:255',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'kategori Berhasil Diupdate');
    }

    // Untuk menghapus kategori yang di pilihD
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'kategori Berhasil Dihapus');
    }
}