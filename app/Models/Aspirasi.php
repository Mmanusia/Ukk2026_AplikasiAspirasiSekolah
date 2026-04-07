<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Kategori;
use App\Models\InputAspirasi;

// Model untuk Aspirasi

// Menggunakan Fillable untuk menentukan atribut yang diisi
#[Fillable([
    'status',
    'kategori_id',
    'feedback',
    'tanggal_dibuat',
])]
class Aspirasi extends Model
{
    // Menentukan nama tabel yang digunakan
    protected $table = 'aspirasis';

    // Mendisable timestamps
    public $timestamps = false;

    /**
     * Cast attribute
     */
    protected function casts(): array
    {
        return [
            'tanggal_dibuat' => 'date',
        ];
    }

    // ======================
    // RELASI
    // ======================

    public function inputAspirasi()
    {
        return $this->hasOne(InputAspirasi::class, 'aspirasi_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}