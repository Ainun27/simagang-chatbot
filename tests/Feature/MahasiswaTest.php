<?php

namespace Tests\Feature;

use App\Models\Divisi;
use App\Models\Mahasiswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MahasiswaTest extends TestCase
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
            'nama_divisi' => 'Teknologi Informasi & Smart City',
            'deskripsi' => 'Pengembangan infrastruktur teknologi dan aplikasi pemerintahan',
            'kuota' => 2,
        ]);
    }

    public function test_can_view_mahasiswa_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.mahasiswa.index'));
        $response->assertStatus(200);
    }

    public function test_can_create_mahasiswa_with_encrypted_data(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.mahasiswa.store'), [
            'nim' => '20210801001',
            'nama' => 'Ahmad Fauzi',
            'email' => 'ahmad.fauzi@kampus.ac.id',
            'no_hp' => '081234567890',
            'universitas' => 'Universitas Indonesia',
            'divisi_id' => $this->divisi->id,
            'tanggal_mulai' => Carbon::today()->format('Y-m-d'),
            'tanggal_selesai' => Carbon::today()->addMonths(3)->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('admin.mahasiswa.index'));

        // Ambil data langsung dari model (otomatis didekripsi oleh Trait)
        $mhs = Mahasiswa::where('nim', '20210801001')->first();
        $this->assertNotNull($mhs);
        $this->assertEquals('Ahmad Fauzi', $mhs->nama);
        $this->assertEquals('ahmad.fauzi@kampus.ac.id', $mhs->email);
        $this->assertEquals('081234567890', $mhs->no_hp);

        // Verifikasi bahwa di database fisik (raw DB query), email dan no_hp tersimpan terenkripsi
        $raw = DB::table('mahasiswa')->where('nim', '20210801001')->first();
        $this->assertNotEquals('ahmad.fauzi@kampus.ac.id', $raw->email);
        $this->assertNotEquals('081234567890', $raw->no_hp);
    }

    public function test_cannot_add_mahasiswa_when_divisi_quota_is_full(): void
    {
        // Isi kuota penuh (kuota = 2)
        Mahasiswa::create([
            'nim' => '20210801001',
            'nama' => 'Peserta 1',
            'email' => 'peserta1@kampus.ac.id',
            'no_hp' => '081234567891',
            'universitas' => 'Kampus A',
            'divisi_id' => $this->divisi->id,
            'tanggal_mulai' => Carbon::today()->format('Y-m-d'),
            'tanggal_selesai' => Carbon::today()->addMonths(3)->format('Y-m-d'),
            'is_active' => true,
        ]);

        Mahasiswa::create([
            'nim' => '20210801002',
            'nama' => 'Peserta 2',
            'email' => 'peserta2@kampus.ac.id',
            'no_hp' => '081234567892',
            'universitas' => 'Kampus B',
            'divisi_id' => $this->divisi->id,
            'tanggal_mulai' => Carbon::today()->format('Y-m-d'),
            'tanggal_selesai' => Carbon::today()->addMonths(3)->format('Y-m-d'),
            'is_active' => true,
        ]);

        // Coba masukkan peserta ke-3
        $response = $this->actingAs($this->admin)->post(route('admin.mahasiswa.store'), [
            'nim' => '20210801003',
            'nama' => 'Peserta 3',
            'email' => 'peserta3@kampus.ac.id',
            'no_hp' => '081234567893',
            'universitas' => 'Kampus C',
            'divisi_id' => $this->divisi->id,
            'tanggal_mulai' => Carbon::today()->format('Y-m-d'),
            'tanggal_selesai' => Carbon::today()->addMonths(3)->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('divisi_id');
        $this->assertDatabaseMissing('mahasiswa', ['nim' => '20210801003']);
    }

    public function test_can_toggle_mahasiswa_status(): void
    {
        $mhs = Mahasiswa::create([
            'nim' => '20210801005',
            'nama' => 'Budi Santoso',
            'email' => 'budi@kampus.ac.id',
            'no_hp' => '081234567895',
            'universitas' => 'Universitas Negeri',
            'divisi_id' => $this->divisi->id,
            'tanggal_mulai' => Carbon::today()->format('Y-m-d'),
            'tanggal_selesai' => Carbon::today()->addMonths(2)->format('Y-m-d'),
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.mahasiswa.toggle-status', $mhs));
        $response->assertStatus(302);

        $mhs->refresh();
        $this->assertFalse((bool) $mhs->is_active);
    }

    public function test_can_deactivate_mahasiswa_via_update_form(): void
    {
        $mhs = Mahasiswa::create([
            'nim' => '20210801006',
            'nama' => 'Citra Lestari',
            'email' => 'citra@kampus.ac.id',
            'no_hp' => '081234567896',
            'universitas' => 'Universitas Mulawarman',
            'divisi_id' => $this->divisi->id,
            'tanggal_mulai' => Carbon::today()->format('Y-m-d'),
            'tanggal_selesai' => Carbon::today()->addMonths(2)->format('Y-m-d'),
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.mahasiswa.update', $mhs->id), [
            'nim' => '20210801006',
            'nama' => 'Citra Lestari',
            'email' => 'citra@kampus.ac.id',
            'no_hp' => '081234567896',
            'universitas' => 'Universitas Mulawarman',
            'divisi_id' => $this->divisi->id,
            'tanggal_mulai' => Carbon::today()->format('Y-m-d'),
            'tanggal_selesai' => Carbon::today()->addMonths(2)->format('Y-m-d'),
            'is_active' => 0,
        ]);

        $response->assertRedirect(route('admin.mahasiswa.index'));

        $mhs->refresh();
        $this->assertFalse((bool) $mhs->is_active);

        // Pastikan setelah buka halaman index, mahasiswa tetap nonaktif (tidak ter-overwrite)
        $this->actingAs($this->admin)->get(route('admin.mahasiswa.index'));
        $mhs->refresh();
        $this->assertFalse((bool) $mhs->is_active);
    }
}
