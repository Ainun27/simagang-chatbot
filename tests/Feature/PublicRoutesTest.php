<?php

namespace Tests\Feature;

use App\Models\Divisi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_access_divisi_public_page(): void
    {
        Divisi::create([
            'nama_divisi' => 'Teknologi Informasi',
            'deskripsi' => 'Divisi pengembangan aplikasi dan sistem',
            'kuota' => 10,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Teknologi Informasi');
    }

    public function test_can_access_informasi_page(): void
    {
        $response = $this->get('/informasi');
        $response->assertStatus(200);
        $response->assertSee('Program Magang');
    }

    public function test_can_access_syarat_page(): void
    {
        $response = $this->get('/syarat');
        $response->assertStatus(200);
        $response->assertSee('Persyaratan Program Magang');
    }

    public function test_can_access_alur_page(): void
    {
        $response = $this->get('/alur');
        $response->assertStatus(200);
        $response->assertSee('Alur Pendaftaran');
    }

    public function test_can_access_standalone_chatbot_page(): void
    {
        $response = $this->get('/chatbot');
        $response->assertStatus(200);
    }
}
