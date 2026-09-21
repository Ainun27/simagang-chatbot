<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MahasiswaExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::with('divisi');
        
        if ($request->filled('divisi_id')) {
            $query->where('divisi_id', $request->divisi_id);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('universitas', 'like', "%{$search}%");
            });
        }
        
        $mahasiswas = $query->latest()->paginate(10)->withQueryString();
        
        $total = Mahasiswa::count();
        $total_aktif = Mahasiswa::where('is_active', true)->count();
        $total_nonaktif = Mahasiswa::where('is_active', false)->count();
        $bulan_ini = Mahasiswa::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        
        $divisi = Divisi::all();
        $tahun_list = $this->getTahunList();
        
        return view('admin.laporan.index', compact(
            'mahasiswas', 'total', 'total_aktif', 'total_nonaktif', 'bulan_ini', 'divisi', 'tahun_list'
        ));
    }
    
    public function exportPage()
    {
        $divisi = Divisi::all();
        $tahun_list = $this->getTahunList();
        $total_data = Mahasiswa::count();
        
        return view('admin.laporan.export_page', compact('divisi', 'tahun_list', 'total_data'));
    }

    private function getTahunList()
    {
        $years = Mahasiswa::select('created_at')
            ->whereNotNull('created_at')
            ->get()
            ->map(fn($m) => $m->created_at->format('Y'))
            ->unique()
            ->values();

        if ($years->isEmpty()) {
            return collect([date('Y')]);
        }

        return $years;
    }
    
    public function exportPdf(Request $request)
    {
        $query = Mahasiswa::with('divisi');
        
        if ($request->filled('divisi_id')) {
            $query->where('divisi_id', $request->divisi_id);
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('universitas', 'like', "%{$search}%");
            });
        }
        
        $data = $query->latest()->get();

        // Ambil info filter untuk kop/keterangan laporan
        $filter_divisi = $request->filled('divisi_id') ? Divisi::find($request->divisi_id)?->nama_divisi : 'Semua Divisi';
        $filter_status = $request->filled('status') ? ($request->status == '1' ? 'Aktif' : 'Nonaktif') : 'Semua Status';
        $filter_periode = ($request->filled('bulan') ? date('F', mktime(0, 0, 0, $request->bulan, 1)) . ' ' : '') . ($request->filled('tahun') ? $request->tahun : 'Semua Periode');
        
        $pdf = Pdf::loadView('admin.laporan.pdf_template', compact('data', 'filter_divisi', 'filter_status', 'filter_periode'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('Laporan_Magang_Diskominfosantik_' . now()->format('d_m_Y_His') . '.pdf');
    }
    
    public function exportExcel(Request $request)
    {
        return Excel::download(new MahasiswaExport($request), 'Laporan_Magang_Diskominfosantik_' . now()->format('d_m_Y_His') . '.xlsx');
    }
}