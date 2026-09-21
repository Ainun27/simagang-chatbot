<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $allDivisi = Divisi::all();
        
        $total_divisi = $allDivisi->count();
        $total_kuota = 0;
        $total_mahasiswa_aktif = 0;
        
        foreach ($allDivisi as $divisi) {
            $mahasiswa_count = $divisi->mahasiswa()
                ->where('is_active', 1)
                ->where(function($q) use ($today) {
                    $q->whereNull('tanggal_selesai')
                      ->orWhere('tanggal_selesai', '>=', $today);
                })->count();
            
            $divisi->mahasiswa_count = $mahasiswa_count;
            $divisi->sisa = max(0, $divisi->kuota - $mahasiswa_count);
            $divisi->persentase = $divisi->kuota > 0 ? 
                ($mahasiswa_count / $divisi->kuota) * 100 : 0;
            
            $isPenuh = $divisi->sisa == 0;
            $isHampirPenuh = !$isPenuh && $divisi->mahasiswa_count > 0 && ($divisi->persentase >= 75 || ($divisi->sisa <= 2 && $divisi->persentase >= 50));
            
            $divisi->is_penuh = $isPenuh;
            $divisi->is_hampir_penuh = $isHampirPenuh;
            $divisi->progress_class = $isPenuh ? 'danger' : ($isHampirPenuh ? 'warning' : 'success');
            
            $total_kuota += $divisi->kuota;
            $total_mahasiswa_aktif += $mahasiswa_count;
        }
        
        $sisa_kuota = max(0, $total_kuota - $total_mahasiswa_aktif);
        $persentase_total = $total_kuota > 0 ? ($total_mahasiswa_aktif / $total_kuota) * 100 : 0;
        
        if ($total_kuota == 0) {
            $sisa_kuota_class = 'secondary';
            $sisa_kuota_icon = 'info-circle';
            $sisa_kuota_text = 'Belum Ada Kuota';
        } elseif ($sisa_kuota == 0) {
            $sisa_kuota_class = 'danger';
            $sisa_kuota_icon = 'times-circle';
            $sisa_kuota_text = 'Penuh';
        } elseif ($persentase_total >= 85 || ($sisa_kuota <= 2 && $persentase_total >= 50 && $total_mahasiswa_aktif > 0)) {
            $sisa_kuota_class = 'warning';
            $sisa_kuota_icon = 'exclamation-triangle';
            $sisa_kuota_text = 'Hampir Penuh';
        } else {
            $sisa_kuota_class = 'success';
            $sisa_kuota_icon = 'check-circle';
            $sisa_kuota_text = 'Tersedia';
        }
        
        $divisi_hampir_penuh = $allDivisi->filter(function($divisi) {
            return $divisi->is_hampir_penuh;
        });
        
        $divisi_penuh = $allDivisi->filter(function($divisi) {
            return $divisi->is_penuh;
        });
        
        $divisi_list = $allDivisi;
        
        return view('admin.dashboard', compact(
            'total_divisi', 'total_kuota', 'sisa_kuota', 'sisa_kuota_class', 'sisa_kuota_icon',
            'sisa_kuota_text', 'total_mahasiswa_aktif', 'divisi_list', 'divisi_hampir_penuh', 'divisi_penuh'
        ));
    }
}