<?php

namespace Tests\Feature;

use App\Models\Divisi;
use App\Models\Mahasiswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Divisi $divisi;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::create([
            'name' => 'Admin Magang',
            'email' => 'admin@diskominfosantik.go.id',
            'password' => bcrypt('password123'),
        ]);

        $this->divisi = Divisi::create([
            'nama_divisi' => 'Infrastruktur TI',
            'deskripsi' => 'Pengelolaan data center dan jaringan',
            'kuota' => 10,
        ]);

        Mahasiswa::create([
            'nim' => '20210001',
            'nama' => 'Rina Melati',
            'email' => 'rina@kampus.ac.id',
            'no_hp' => '081234567899',
            'universitas' => 'Institut Teknologi Bandung',
            'divisi_id' => $this->divisi->id,
            'tanggal_mulai' => Carbon::today()->subMonth()->format('Y-m-d'),
            'tanggal_selesai' => Carbon::today()->addMonths(2)->format('Y-m-d'),
            'is_active' => true,
        ]);
    }

    public function test_can_view_laporan_index_with_filters(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.laporan.index', [
            'divisi_id' => $this->divisi->id,
            'status' => '1',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Rina Melati');
    }

    public function test_can_view_export_settings_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.laporan.export.page'));
        $response->assertStatus(200);
        $response->assertSee('Pusat Cetak');
    }

    public function test_can_export_pdf_report(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.laporan.export.pdf', [
            'divisi_id' => $this->divisi->id,
        ]));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_can_export_excel_report(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.laporan.export.excel', [
            'divisi_id' => $this->divisi->id,
        ]));

        $response->assertStatus(200);
        $this->assertTrue(
            str_contains($response->headers->get('content-type'), 'spreadsheetml') ||
            str_contains($response->headers->get('content-type'), 'application/vnd') ||
            str_contains($response->headers->get('content-disposition'), 'Laporan_Magang')
        );
    }
}
