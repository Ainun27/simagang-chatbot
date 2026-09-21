<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptionTrait;
use Carbon\Carbon;

class Mahasiswa extends Model
{
    use HasUuids, EncryptionTrait;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'mahasiswa';
    
    protected $fillable = [
        'nim', 
        'nama', 
        'email', 
        'no_hp',
        'universitas', 
        'divisi_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active'
    ];

    // HANYA email dan no_hp yang dienkripsi (NIM TIDAK)
    protected $encryptable = ['email', 'no_hp'];

    protected $attributes = [
        'is_active' => true
    ];
    
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean'
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Aktif' : 'Nonaktif';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->is_active 
            ? '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Aktif</span>'
            : '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Nonaktif</span>';
    }

    public function getIsExpiredAttribute()
    {
        if (!$this->tanggal_selesai) return false;
        return now()->gt(Carbon::parse($this->tanggal_selesai));
    }

    public function getSisaHariAttribute()
    {
        if (!$this->tanggal_selesai) return null;
        
        $today = now();
        $selesai = Carbon::parse($this->tanggal_selesai);
        
        if ($selesai->lt($today)) return -1;
        
        return $today->diffInDays($selesai);
    }

    public function getMasaMagangTextAttribute()
    {
        if (!$this->tanggal_mulai || !$this->tanggal_selesai) return '-';
        
        $mulai = Carbon::parse($this->tanggal_mulai);
        $selesai = Carbon::parse($this->tanggal_selesai);
        $hari = $mulai->diffInDays($selesai);
        
        return $this->formatMasaMagang($hari);
    }

    private function formatMasaMagang($hari)
    {
        if ($hari >= 365) {
            $tahun = floor($hari / 365);
            $sisaHari = $hari % 365;
            
            if ($sisaHari >= 30) {
                $bulan = floor($sisaHari / 30);
                return "{$tahun} tahun {$bulan} bulan";
            }
            return "{$tahun} tahun";
        }
        
        if ($hari >= 30) {
            $bulan = floor($hari / 30);
            $sisaHari = $hari % 30;
            
            if ($sisaHari > 0) {
                return "{$bulan} bulan {$sisaHari} hari";
            }
            return "{$bulan} bulan";
        }
        
        return "{$hari} hari";
    }

    public function scopeAktif($query)
    {
        $today = Carbon::today()->toDateString();
        return $query->where('is_active', true)
            ->where(function($q) use ($today) {
                $q->whereNull('tanggal_selesai')
                  ->orWhere('tanggal_selesai', '>=', $today);
            });
    }

    public function scopeNonaktif($query)
    {
        $today = Carbon::today()->toDateString();
        return $query->where(function($q) use ($today) {
            $q->where('is_active', false)
              ->orWhere(function($q2) use ($today) {
                  $q2->whereNotNull('tanggal_selesai')
                     ->where('tanggal_selesai', '<', $today);
              });
        });
    }

    public function scopeSelesai($query)
    {
        $today = Carbon::today()->toDateString();
        return $query->whereNotNull('tanggal_selesai')
            ->where('tanggal_selesai', '<', $today);
    }
}