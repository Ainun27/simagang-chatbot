<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;  // ← TAMBAHKAN
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasUuids;  // ← TAMBAHKAN

    protected $table = 'divisi';
    
    protected $keyType = 'string';  // ← TAMBAHKAN
    public $incrementing = false;   // ← TAMBAHKAN
    
    protected $fillable = [
        'id',               // ← TAMBAHKAN (WAJIB!)
        'nama_divisi',
        'deskripsi',
        'kuota'
    ];

    protected $casts = [
        'kuota' => 'integer'
    ];

    // ===== RELASI =====
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    // ===== ACCESSOR =====
    public function getSisaKuotaAttribute()
    {
        return $this->kuota - $this->mahasiswa()->where('is_active', 1)->count();
    }

    public function getPersentaseTerisiAttribute()
    {
        if ($this->kuota == 0) return 0;
        $aktif = $this->mahasiswa()->where('is_active', 1)->count();
        return ($aktif / $this->kuota) * 100;
    }

    public function getStatusKuotaAttribute()
    {
        $sisa = $this->sisa_kuota;
        $aktif = $this->mahasiswa()->where('is_active', 1)->count();
        if ($sisa == 0) return 'penuh';
        if ($aktif > 0 && ($this->persentase_terisi >= 75 || ($sisa <= 2 && $this->persentase_terisi >= 50))) {
            return 'hampir_penuh';
        }
        return 'tersedia';
    }

    public function getInitialAttribute()
    {
        return strtoupper(substr($this->nama_divisi, 0, 1));
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y');
    }

    public function getRelativeDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}