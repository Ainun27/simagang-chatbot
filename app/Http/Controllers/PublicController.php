<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Support\Carbon;

class PublicController extends Controller
{
    public function divisi()
    {
        $today = Carbon::today()->toDateString();
        
        // Ambil divisi dengan mahasiswa AKTIF SAJA (yang belum selesai magang)
        $divisi = Divisi::with(['mahasiswa' => function($query) use ($today) {
            $query->where('is_active', true)
                  ->where(function($q) use ($today) {
                      $q->whereNull('tanggal_selesai')
                        ->orWhere('tanggal_selesai', '>=', $today);
                  });
        }])->get();
        
        // Hitung jumlah mahasiswa aktif per divisi
        foreach ($divisi as $d) {
            $d->mahasiswa_count = $d->mahasiswa->count();
            $d->sisa = $d->kuota - $d->mahasiswa_count;
            $d->persentase = $d->kuota > 0 
                ? ($d->mahasiswa_count / $d->kuota) * 100 
                : 0;
        }
        
        return view('public.divisi', compact('divisi'));
    }

    public function informasi()
    {
        $divisi = Divisi::all();
        return view('public.informasi', compact('divisi'));
    }

    public function syarat()
    {
        return view('public.syarat');
    }

    public function alur()
    {
        return view('public.alur');
    }

    // ===== TAMBAHKAN METHOD CHATBOT =====
    public function chatbot()
    {
        return view('public.chatbot');
    }
}