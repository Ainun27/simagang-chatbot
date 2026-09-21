<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\Mahasiswa;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $this->autoUpdateStatus();
        
        $query = Mahasiswa::with('divisi');
        
        if ($request->filled('status') && $request->status !== 'semua') {
            if ($request->status === 'aktif') {
                $query->aktif();
            } elseif ($request->status === 'nonaktif') {
                $query->nonaktif();
            } elseif ($request->status === 'selesai') {
                $query->selesai();
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('universitas', 'like', "%{$search}%");
            });
        }
        
        $today = Carbon::today()->toDateString();

        $query->orderByRaw("
            CASE 
                WHEN is_active = true AND (tanggal_selesai IS NULL OR tanggal_selesai >= ?) THEN 1
                WHEN is_active = false AND (tanggal_selesai IS NULL OR tanggal_selesai >= ?) THEN 2
                ELSE 3
            END
        ", [$today, $today])->latest();
        
        $mahasiswa = $query->paginate(15);
        
        $today = Carbon::today()->toDateString();
        $totalMahasiswa = Mahasiswa::count();
        
        $mahasiswaAktif = Mahasiswa::where('is_active', true)
            ->where(function($q) use ($today) {
                $q->whereNull('tanggal_selesai')
                  ->orWhere('tanggal_selesai', '>=', $today);
            })->count();
        
        $mahasiswaNonaktif = Mahasiswa::where(function($q) use ($today) {
            $q->where('is_active', false)
              ->orWhere(function($q2) use ($today) {
                  $q2->whereNotNull('tanggal_selesai')
                     ->where('tanggal_selesai', '<', $today);
              });
        })->count();
        
        $mahasiswaSelesai = Mahasiswa::whereNotNull('tanggal_selesai')
            ->where('tanggal_selesai', '<', $today)->count();
        
        $persentaseAktif = $totalMahasiswa > 0 ? round(($mahasiswaAktif / $totalMahasiswa) * 100) : 0;
        $persentaseNonaktif = $totalMahasiswa > 0 ? round(($mahasiswaNonaktif / $totalMahasiswa) * 100) : 0;
        
        return view('admin.mahasiswa.index', compact(
            'mahasiswa', 'totalMahasiswa', 'mahasiswaAktif', 'mahasiswaNonaktif',
            'mahasiswaSelesai', 'persentaseAktif', 'persentaseNonaktif'
        ));
    }
    
    private function autoUpdateStatus(): void
    {
        $today = Carbon::today()->toDateString();
        
        // Hanya otomatis menonaktifkan mahasiswa yang tanggal selesainya sudah lewat
        Mahasiswa::where('is_active', true)
            ->whereNotNull('tanggal_selesai')
            ->whereDate('tanggal_selesai', '<', $today)
            ->update(['is_active' => false, 'updated_at' => now()]);
    }

    public function batchUpdateStatus()
    {
        $beforeActive = Mahasiswa::where('is_active', true)->count();
        $this->autoUpdateStatus();
        $afterActive = Mahasiswa::where('is_active', true)->count();
        $diff = $beforeActive - $afterActive;
        
        return redirect()->route('admin.mahasiswa.index')
            ->with('success', "Status telah disinkronisasi! {$diff} mahasiswa dinonaktifkan otomatis.");
    }

    public function create()
    {
        $divisi = Divisi::all();
        return view('admin.mahasiswa.create', compact('divisi'));
    }

    public function store(StoreMahasiswaRequest $request)
    {
        $validated = $request->validated();

        // Cek Kuota Divisi
        $divisi = Divisi::findOrFail($validated['divisi_id']);
        $terisi = $divisi->mahasiswa()->where('is_active', true)->count();
        
        if ($terisi >= $divisi->kuota) {
            return back()->withErrors([
                'divisi_id' => "Kuota divisi {$divisi->nama_divisi} sudah penuh! (Terisi: {$terisi}/{$divisi->kuota})"
            ])->withInput();
        }
        
        // Set status otomatis berdasarkan tanggal selesai
        $today = Carbon::today();
        $tanggalSelesai = Carbon::parse($validated['tanggal_selesai']);
        $validated['is_active'] = $tanggalSelesai->greaterThanOrEqualTo($today);
        
        Mahasiswa::create($validated);
        
        return redirect()->route('admin.mahasiswa.index')
            ->with('success', "Mahasiswa {$validated['nama']} berhasil ditambahkan!");
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load('divisi');
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $divisi = Divisi::all();
        return view('admin.mahasiswa.edit', compact('mahasiswa', 'divisi'));
    }

    public function update(UpdateMahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validated();
        
        // Cek kuota jika berganti divisi dan aktif
        if ($mahasiswa->divisi_id !== $validated['divisi_id'] && $validated['is_active']) {
            $divisi = Divisi::findOrFail($validated['divisi_id']);
            $terisi = $divisi->mahasiswa()->where('is_active', true)->where('id', '!=', $mahasiswa->id)->count();
            
            if ($terisi >= $divisi->kuota) {
                return back()->withErrors([
                    'divisi_id' => "Kuota divisi {$divisi->nama_divisi} sudah penuh!"
                ])->withInput();
            }
        }
        
        // Validasi status vs tanggal selesai
        $today = Carbon::today();
        $tanggalSelesai = Carbon::parse($validated['tanggal_selesai']);
        
        if ($validated['is_active'] && $tanggalSelesai->lt($today)) {
            return back()->withErrors([
                'is_active' => "Tidak bisa mengaktifkan karena tanggal selesai sudah lewat."
            ])->withInput();
        }
        
        $mahasiswa->update($validated);
        
        return redirect()->route('admin.mahasiswa.index')
            ->with('success', "Data mahasiswa {$validated['nama']} berhasil diupdate!");
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $nama = $mahasiswa->nama;
        $mahasiswa->delete();
        
        return redirect()->route('admin.mahasiswa.index')
            ->with('success', "Mahasiswa {$nama} berhasil dihapus!");
    }

    public function toggleStatus(Mahasiswa $mahasiswa)
    {
        $today = Carbon::today();
        
        if (!$mahasiswa->is_active && $mahasiswa->tanggal_selesai) {
            if (Carbon::parse($mahasiswa->tanggal_selesai)->lt($today)) {
                return back()->with('error', "Tidak bisa mengaktifkan karena tanggal selesai sudah lewat.");
            }
        }
        
        $mahasiswa->is_active = !$mahasiswa->is_active;
        $mahasiswa->save();
        
        $status = $mahasiswa->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()->with('success', "Mahasiswa {$mahasiswa->nama} berhasil {$status}!");
    }

    public function cekNim(Request $request)
    {
        $nim = $request->get('nim');
        $exists = Mahasiswa::where('nim', $nim)->exists();
        
        return response()->json([
            'exists' => $exists
        ]);
    }
}