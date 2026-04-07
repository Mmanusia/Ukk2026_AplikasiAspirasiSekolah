<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Aspirasi;

// Model untuk InputAspirasi

// Menggunakan Fillable untuk menentukan atribut yang diisi
#[Fillable(['user_id', 'kategori_id', 'lokasi', 'ket', 'tanggal_aspirasi', 'aspirasi_id', 'foto'])]
class InputAspirasi extends Model
{
    // Menentukan nama tabel yang digunakan
    protected $table = 'input_aspirasis';

    // Mendisable timestamps
    public $timestamps = false;

    /**
     * Cast attribute
     */
    protected function casts(): array
    {
        return [
            'tanggal_aspirasi' => 'date',
        ];
    }

    // ======================
    // RELASI
    // ======================

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class, 'aspirasi_id');
    }
}