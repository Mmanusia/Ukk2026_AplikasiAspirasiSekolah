<?php

namespace Tests\Feature;

use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AspirasiStatusFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_filter_aspirasi_by_status(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Sekolah',
            'role' => 'admin',
        ]);

        $kategori = Kategori::create([
            'ket_kategori' => 'Fasilitas',
        ]);

        $menungguUser = User::factory()->create([
            'name' => 'Siswa Menunggu',
            'role' => 'siswa',
        ]);
        $prosesUser = User::factory()->create([
            'name' => 'Siswa Proses',
            'role' => 'siswa',
        ]);
        $selesaiUser = User::factory()->create([
            'name' => 'Siswa Selesai',
            'role' => 'siswa',
        ]);

        $menunggu = InputAspirasi::create([
            'user_id' => $menungguUser->id,
            'kategori_id' => $kategori->id,
            'lokasi' => 'Ruang Kelas 1',
            'ket' => 'Lampu kelas mati',
            'tanggal_aspirasi' => '2026-04-01',
            'aspirasi_id' => null,
        ]);

        $prosesAspirasi = Aspirasi::create([
            'status' => 'proses',
            'kategori_id' => $kategori->id,
            'feedback' => 'Sedang ditindaklanjuti',
            'tanggal_dibuat' => '2026-04-02',
        ]);

        $proses = InputAspirasi::create([
            'user_id' => $prosesUser->id,
            'kategori_id' => $kategori->id,
            'lokasi' => 'Laboratorium',
            'ket' => 'Komputer lambat',
            'tanggal_aspirasi' => '2026-04-02',
            'aspirasi_id' => $prosesAspirasi->id,
        ]);

        $selesaiAspirasi = Aspirasi::create([
            'status' => 'selesai',
            'kategori_id' => $kategori->id,
            'feedback' => 'Sudah diperbaiki',
            'tanggal_dibuat' => '2026-04-03',
        ]);

        $selesai = InputAspirasi::create([
            'user_id' => $selesaiUser->id,
            'kategori_id' => $kategori->id,
            'lokasi' => 'Perpustakaan',
            'ket' => 'AC terlalu panas',
            'tanggal_aspirasi' => '2026-04-03',
            'aspirasi_id' => $selesaiAspirasi->id,
        ]);

        $this->actingAs($admin)
            ->get(route('aspirasi.index'))
            ->assertOk()
            ->assertSeeText('Siswa Menunggu')
            ->assertSeeText('Siswa Proses')
            ->assertSeeText('Siswa Selesai');

        $this->actingAs($admin)
            ->get(route('aspirasi.index', ['status' => 'menunggu']))
            ->assertOk()
            ->assertSeeText('Siswa Menunggu')
            ->assertDontSeeText('Siswa Proses')
            ->assertDontSeeText('Siswa Selesai');

        $this->actingAs($admin)
            ->get(route('aspirasi.index', ['status' => 'proses']))
            ->assertOk()
            ->assertSeeText('Siswa Proses')
            ->assertDontSeeText('Siswa Menunggu')
            ->assertDontSeeText('Siswa Selesai');

        $this->actingAs($admin)
            ->get(route('aspirasi.index', ['status' => 'selesai']))
            ->assertOk()
            ->assertSeeText('Siswa Selesai')
            ->assertDontSeeText('Siswa Menunggu')
            ->assertDontSeeText('Siswa Proses');
    }
}