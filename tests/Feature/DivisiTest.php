<?php

namespace Tests\Feature;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DivisiTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::create([
            'name' => 'Admin Magang',
            'email' => 'admin@diskominfosantik.go.id',
            'password' => bcrypt('password123'),
        ]);
    }

    public function test_can_view_divisi_index_as_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.divisi.index'));
        $response->assertStatus(200);
    }

    public function test_can_create_divisi(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.divisi.store'), [
            'nama_divisi' => 'Divisi Siber & Sandi',
            'deskripsi' => 'Pengamanan informasi dan infrastruktur jaringan siber daerah',
            'kuota' => 5,
        ]);

        $response->assertRedirect(route('admin.divisi.index'));
        $this->assertDatabaseHas('divisi', [
            'nama_divisi' => 'Divisi Siber & Sandi',
            'kuota' => 5,
        ]);
    }

    public function test_can_update_divisi(): void
    {
        $divisi = Divisi::create([
            'nama_divisi' => 'Divisi Humas & IKP',
            'deskripsi' => 'Pengelolaan komunikasi publik dan publikasi program',
            'kuota' => 4,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.divisi.update', $divisi), [
            'nama_divisi' => 'Divisi IKP & Media',
            'deskripsi' => 'Pengelolaan komunikasi publik, media cetak dan media online',
            'kuota' => 6,
        ]);

        $response->assertRedirect(route('admin.divisi.index'));
        $this->assertDatabaseHas('divisi', [
            'id' => $divisi->id,
            'nama_divisi' => 'Divisi IKP & Media',
            'kuota' => 6,
        ]);
    }

    public function test_can_delete_empty_divisi(): void
    {
        $divisi = Divisi::create([
            'nama_divisi' => 'Divisi Sementara',
            'deskripsi' => 'Divisi untuk pengujian sistem hapus data',
            'kuota' => 2,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.divisi.destroy', $divisi));
        $response->assertRedirect(route('admin.divisi.index'));
        $this->assertDatabaseMissing('divisi', ['id' => $divisi->id]);
    }
}
