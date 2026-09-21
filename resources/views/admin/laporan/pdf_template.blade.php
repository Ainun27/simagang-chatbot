<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Mahasiswa Magang - Diskominfosantik</title>
    <style>
        @page {
            margin: 1.2cm 1.2cm 1.5cm 1.2cm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.4;
        }

        /* ===== KOP SURAT RESMI ===== */
        .kop-table {
            width: 100%;
            border-bottom: 3px double #1e293b;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .kop-table td {
            vertical-align: middle;
            border: none;
            padding: 0;
        }
        .kop-text {
            text-align: center;
        }
        .kop-text h4 {
            margin: 0;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #334155;
            text-transform: uppercase;
        }
        .kop-text h2 {
            margin: 2px 0;
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kop-text p {
            margin: 2px 0 0 0;
            font-size: 9px;
            color: #475569;
        }

        /* ===== JUDUL LAPORAN ===== */
        .report-title-box {
            text-align: center;
            margin-bottom: 15px;
        }
        .report-title-box h3 {
            margin: 0 0 4px 0;
            font-size: 13px;
            font-weight: 700;
            color: #1e1b4b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .report-title-box .report-meta-info {
            font-size: 9px;
            color: #64748b;
        }

        /* ===== META FILTER BOX ===== */
        .filter-info-box {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 6px 10px;
            margin-bottom: 12px;
            font-size: 9px;
        }
        .filter-info-table {
            width: 100%;
            border: none;
        }
        .filter-info-table td {
            border: none;
            padding: 2px 4px;
            color: #334155;
        }
        .filter-info-table td strong {
            color: #0f172a;
        }

        /* ===== TABEL DATA ===== */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th {
            background-color: #4f46e5;
            color: #ffffff;
            font-weight: 700;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 7px 6px;
            border: 1px solid #4338ca;
            text-align: left;
        }
        .data-table td {
            padding: 6px;
            border: 1px solid #cbd5e1;
            font-size: 9px;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* ===== BADGES ===== */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8px;
            font-weight: bold;
            border-radius: 3px;
        }
        .badge-active {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .badge-inactive {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* ===== TANDA TANGAN / PENGESAHAN ===== */
        .signature-section {
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
        }
        .signature-table {
            width: 100%;
            border: none;
        }
        .signature-table td {
            border: none;
            padding: 0;
            vertical-align: top;
        }
        .signature-box {
            text-align: center;
            width: 250px;
            float: right;
        }
        .signature-box .date-line {
            margin-bottom: 5px;
            font-size: 9.5px;
        }
        .signature-box .role-line {
            font-weight: 600;
            margin-bottom: 50px;
            font-size: 9.5px;
        }
        .signature-box .name-line {
            font-weight: 700;
            text-decoration: underline;
            font-size: 10px;
        }
        .signature-box .nip-line {
            font-size: 9px;
            color: #475569;
        }

        /* ===== FOOTER DOKUMEN ===== */
        .doc-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 8px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 4px;
            text-align: right;
        }
    </style>
</head>
<body>
    <!-- KOP SURAT -->
    <table class="kop-table">
        <tr>
            <td class="kop-text">
                <h4>PEMERINTAH KABUPATEN BEKASI</h4>
                <h2>DINAS KOMUNIKASI, INFORMATIKA, PERSANDIAN DAN STATISTIK</h2>
                <p>Kompleks Perkantoran Pemkab Bekasi, Desa Sukamahi, Kec. Cikarang Pusat, Kab. Bekasi, Jawa Barat 17530</p>
                <p>Laman: diskominfosantik.bekasikab.go.id | Email: kominfo@bekasikab.go.id</p>
            </td>
        </tr>
    </table>

    <!-- JUDUL & METADATA -->
    <div class="report-title-box">
        <h3>Laporan Rekapitulasi Data Mahasiswa Magang</h3>
        <div class="report-meta-info">Sistem Informasi Manajemen Magang (SIMAGANG)</div>
    </div>

    <!-- PARAMETER FILTER INFO -->
    <div class="filter-info-box">
        <table class="filter-info-table">
            <tr>
                <td style="width: 25%;"><strong>Divisi Magang:</strong> {{ $filter_divisi ?? 'Semua Divisi' }}</td>
                <td style="width: 25%;"><strong>Status Peserta:</strong> {{ $filter_status ?? 'Semua Status' }}</td>
                <td style="width: 25%;"><strong>Periode Data:</strong> {{ $filter_periode ?? 'Semua Periode' }}</td>
                <td style="width: 25%; text-align: right;"><strong>Total Data:</strong> {{ $data->count() }} Mahasiswa</td>
            </tr>
        </table>
    </div>

    <!-- TABEL DATA LAPORAN -->
    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 4%;">No</th>
                <th style="width: 12%;">NIM</th>
                <th style="width: 20%;">Nama Mahasiswa</th>
                <th style="width: 20%;">Universitas / Kampus</th>
                <th style="width: 16%;">Divisi</th>
                <th style="width: 16%;">Periode Magang</th>
                <th class="text-center" style="width: 12%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $mhs)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><strong>{{ $mhs->nim }}</strong></td>
                <td>{{ $mhs->nama }}</td>
                <td>{{ $mhs->universitas }}</td>
                <td>{{ $mhs->divisi->nama_divisi ?? '-' }}</td>
                <td>
                    {{ $mhs->tanggal_mulai ? $mhs->tanggal_mulai->format('d/m/Y') : '-' }} s/d 
                    {{ $mhs->tanggal_selesai ? $mhs->tanggal_selesai->format('d/m/Y') : '-' }}
                </td>
                <td class="text-center">
                    @if($mhs->is_active)
                        <span class="badge badge-active">AKTIF</span>
                    @else
                        <span class="badge badge-inactive">NONAKTIF</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px; color: #64748b;">
                    Tidak ada data mahasiswa magang yang sesuai dengan kriteria filter.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td style="width: 60%;"></td>
                <td style="width: 40%;">
                    <div class="signature-box">
                        <div class="date-line">Bekasi, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                        <div class="role-line">Pengelola Program Magang<br>Diskominfosantik Kabupaten Bekasi</div>
                        <div class="name-line">Administrator SIMAGANG</div>
                        <div class="nip-line">Dokumen Sah Terverifikasi Sistem</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="doc-footer">
        Dicetak otomatis oleh Sistem SIMAGANG Diskominfosantik Kab. Bekasi pada {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>