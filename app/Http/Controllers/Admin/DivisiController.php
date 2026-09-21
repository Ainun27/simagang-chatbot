<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDivisiRequest;
use App\Http\Requests\UpdateDivisiRequest;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DivisiController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        
        $divisi = Divisi::with(['mahasiswa' => function($query) use ($today) {
            $query->where('is_active', true)
                  ->where(function($q) use ($today) {
                      $q->whereNull('tanggal_selesai')
                        ->orWhere('tanggal_selesai', '>=', $today);
                  });
        }])->latest()->get();
        
        $totalKuota = 0;
        $totalMahasiswaAktif = 0;
        
        foreach ($divisi as $d) {
            $mahasiswaAktif = $d->mahasiswa->count();
            $d->mahasiswa_aktif_count = $mahasiswaAktif;
            $d->sisa_kuota = $d->kuota - $mahasiswaAktif;
            $totalKuota += $d->kuota;
            $totalMahasiswaAktif += $mahasiswaAktif;
        }
        
        $totalSisaKuota = $totalKuota - $totalMahasiswaAktif;
        
        return view('admin.divisi.index', compact('divisi', 'totalKuota', 'totalMahasiswaAktif', 'totalSisaKuota'));
    }

    public function create()
    {
        return view('admin.divisi.create');
    }

    public function store(StoreDivisiRequest $request)
    {
        Divisi::create($request->validated());

        return redirect()->route('admin.divisi.index')
            ->with('success', 'Divisi berhasil ditambahkan!');
    }

    public function show(Divisi $divisi)
    {
        $divisi->load(['mahasiswa' => function($query) {
            $query->where('is_active', true);
        }]);
        
        return view('admin.divisi.show', compact('divisi'));
    }

    public function edit(Divisi $divisi)
    {
        $divisi->loadCount(['mahasiswa' => function($query) {
            $query->where('is_active', true);
        }]);
        
        return view('admin.divisi.edit', compact('divisi'));
    }

    public function update(UpdateDivisiRequest $request, Divisi $divisi)
    {
        $divisi->loadCount('mahasiswa');
        $validated = $request->validated();

        if ($validated['kuota'] < $divisi->mahasiswa_count) {
            return back()->withErrors([
                'kuota' => "Kuota tidak bisa dikurangi karena sudah ada {$divisi->mahasiswa_count} mahasiswa terdaftar!"
            ])->withInput();
        }

        $divisi->update($validated);

        return redirect()->route('admin.divisi.index')
            ->with('success', 'Divisi berhasil diupdate!');
    }

    public function destroy(Divisi $divisi)
    {
        $divisi->loadCount('mahasiswa');

        if ($divisi->mahasiswa_count > 0) {
            return back()->with('error', 'Tidak dapat menghapus divisi yang masih memiliki mahasiswa!');
        }

        $nama_divisi = $divisi->nama_divisi;
        $divisi->delete();

        return redirect()->route('admin.divisi.index')
            ->with('success', "Divisi {$nama_divisi} berhasil dihapus!");
    }

    public function cekNama(Request $request)
    {
        $nama = $request->get('nama');
        $exists = Divisi::where('nama_divisi', $nama)->exists();
        
        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Nama divisi sudah ada!' : 'Nama divisi tersedia'
        ]);
    }
}