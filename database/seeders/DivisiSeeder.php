<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Divisi;
use Illuminate\Support\Str;  // ← TAMBAHKAN INI

class DivisiSeeder extends Seeder
{
    public function run()
    {
        $divisi = [
            [
                'id' => Str::uuid(),  // ← TAMBAHKAN INI
                'nama_divisi' => 'IT & Programmer',
                'deskripsi' => 'Divisi pengembangan aplikasi, website, dan sistem informasi',
                'kuota' => 5
            ],
            [
                'id' => Str::uuid(),  // ← TAMBAHKAN INI
                'nama_divisi' => 'Desain Grafis',
                'deskripsi' => 'Divisi desain visual, multimedia, dan konten kreatif',
                'kuota' => 3
            ],
            [
                'id' => Str::uuid(),  // ← TAMBAHKAN INI
                'nama_divisi' => 'Data Analyst',
                'deskripsi' => 'Divisi analisis data, visualisasi, dan business intelligence',
                'kuota' => 4
            ],
            [
                'id' => Str::uuid(),  // ← TAMBAHKAN INI
                'nama_divisi' => 'Jaringan & Infrastruktur',
                'deskripsi' => 'Divisi maintenance server, jaringan, dan infrastruktur IT',
                'kuota' => 2
            ],
            [
                'id' => Str::uuid(),  // ← TAMBAHKAN INI
                'nama_divisi' => 'Media & Publikasi',
                'deskripsi' => 'Divisi konten media sosial, dokumentasi, dan publikasi',
                'kuota' => 3
            ],
        ];

        foreach ($divisi as $d) {
            Divisi::create($d);
        }
    }
}