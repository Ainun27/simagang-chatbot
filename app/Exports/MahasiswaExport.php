<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Mahasiswa::query()->with('divisi');

        if ($this->request->filled('divisi_id')) {
            $query->where('divisi_id', $this->request->divisi_id);
        }
        if ($this->request->filled('status')) {
            $query->where('is_active', $this->request->status);
        }
        if ($this->request->filled('bulan')) {
            $query->whereMonth('created_at', $this->request->bulan);
        }
        if ($this->request->filled('tahun')) {
            $query->whereYear('created_at', $this->request->tahun);
        }
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('universitas', 'like', "%{$search}%");
            });
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Mahasiswa',
            'Universitas / Kampus',
            'Divisi Magang',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Masa Magang',
            'Status Magang',
            'Tanggal Terdaftar Sistem'
        ];
    }

    public function map($mhs): array
    {
        return [
            $mhs->nim,
            $mhs->nama,
            $mhs->universitas,
            $mhs->divisi->nama_divisi ?? '-',
            $mhs->tanggal_mulai ? $mhs->tanggal_mulai->format('d/m/Y') : '-',
            $mhs->tanggal_selesai ? $mhs->tanggal_selesai->format('d/m/Y') : '-',
            $mhs->masa_magang_text ?? '-',
            $mhs->is_active ? 'Aktif' : 'Nonaktif',
            $mhs->created_at ? $mhs->created_at->format('d/m/Y H:i') : '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => '4F46E5']
                ]
            ],
        ];
    }
}