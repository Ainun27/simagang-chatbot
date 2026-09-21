<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Ambil semua data mahasiswa
        $mahasiswas = DB::table('mahasiswa')->get();
        
        foreach ($mahasiswas as $mhs) {
            // Coba decrypt NIM (jika terenkripsi)
            try {
                $nimDecrypted = decrypt($mhs->nim);
                DB::table('mahasiswa')
                    ->where('id', $mhs->id)
                    ->update(['nim' => $nimDecrypted]);
            } catch (\Exception $e) {
                // Jika tidak bisa di-decrypt, biarkan saja (sudah plain text)
            }
        }
    }

    public function down()
    {
        // Tidak perlu rollback
    }
};