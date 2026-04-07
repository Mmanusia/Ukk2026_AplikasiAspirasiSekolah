<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Aspirasi;
use App\Models\InputAspirasi;
// Model untuk Kategori

// Menggunakan Fillable untuk menentukan atribut yang diisi
#[Fillable(['ket_kategori'])]

class Kategori extends Model
{
    // Menentukan nama tabel yang digunakan
    protected $table = 'kategoris';

    // Mendisable timestamps
    public $timestamps = false;

    // ======================
    // RELASI
    // ======================


    public function aspirasis()
    {
        return $this->hasMany(Aspirasi::class, 'kategori_id');
    }

    public function input_aspirasis()
    {
        return $this->hasMany(InputAspirasi::class, 'kategori_id');
    }
}