<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventaris Keseluruhan</title>
    <style>
        @page {
            margin: 1.0cm 1.2cm;
        }
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            font-size: 10px; 
            color: #1e293b; 
            line-height: 1.4;
        }
        
        /* STYLING KOP SURAT DINAS RESMI */
        .kop-surat { 
            width: 100%; 
            border-bottom: 3px double #0f172a; 
            padding-bottom: 8px; 
            margin-bottom: 15px; 
            border-collapse: collapse; 
        }
        .kop-surat td { 
            vertical-align: middle; 
            border: none !important;
            padding: 0;
        }
        .kop-logo { 
            width: 12%; 
            text-align: center; 
        }
        .kop-logo img {
            width: 65px;
            height: auto;
        }
        .kop-teks { 
            width: 76%; 
            text-align: center; 
            line-height: 1.25; 
        }

        /* JUDUL LAPORAN */
        .judul-laporan { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        .judul-laporan h2 { 
            margin: 0; 
            font-size: 14px; 
            font-weight: 800;
            text-transform: uppercase; 
            letter-spacing: 0.5px;
            color: #0f172a;
        }
        .judul-laporan p {
            margin: 3px 0 0 0;
            font-size: 9.5px;
            color: #64748b;
        }

        /* PEMBATAS RUANGAN */
        .ruangan-title { 
            background-color: #f1f5f9; 
            font-weight: bold; 
            padding: 6px 10px; 
            font-size: 10.5px; 
            margin-top: 18px; 
            margin-bottom: 8px;
            border-left: 4px solid #2563eb; 
            color: #0f172a;
            page-break-after: avoid;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* TABEL DATA BARANG */
        table.data-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px; 
            table-layout: fixed;
        }
        table.data-table th { 
            background-color: #1e293b; 
            color: #ffffff; 
            text-transform: uppercase; 
            font-size: 9.5px; 
            letter-spacing: 0.3px;
            font-weight: bold;
            padding: 7px 6px; 
            border: 1px solid #334155; 
            vertical-align: middle;
        }
        table.data-table td { 
            padding: 6px 6px; 
            border: 1px solid #cbd5e1; 
            font-size: 9.5px;
            vertical-align: middle;
            word-wrap: break-word;
        }
        table.data-table tr:nth-child(even) { 
            background-color: #f8fafc; 
        }

        /* SPESIFIKASI KELAS KOLOM UNTUK KERAPIAN ALIGNMENT */
        .col-no { width: 5%; text-align: center; }
        .col-kode { width: 14%; text-align: center; font-family: monospace; font-size: 9px; }
        .col-nama { width: 20%; text-align: left; }
        .col-merk { width: 12%; text-align: left; }
        .col-spek { width: 22%; text-align: left; vertical-align: top; }
        .col-jml { width: 6%; text-align: center; font-weight: bold; }
        .col-kondisi { width: 11%; text-align: center; }
        .col-ket { width: 10%; text-align: center; }

        /* BADGE KONDISI BARANG */
        .badge { 
            padding: 3px 6px; 
            font-size: 8.5px; 
            font-weight: bold; 
            border-radius: 4px; 
            display: inline-block; 
            text-align: center;
            white-space: nowrap;
        }
        .badge-baik { 
            background-color: #dcfce7; 
            color: #15803d; 
            border: 1px solid #bbf7d0;
        }
        .badge-rusak-ringan { 
            background-color: #fef3c7; 
            color: #d97706; 
            border: 1px solid #fde68a;
        }
        .badge-rusak { 
            background-color: #fee2e2; 
            color: #b91c1c; 
            border: 1px solid #fca5a5;
        }

        /* TANDA TANGAN LEGALITAS */
        .ttd-table {
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
            font-size: 10px;
            border-collapse: collapse;
        }
        .ttd-table td {
            width: 50%;
            vertical-align: top;
            text-align: center;
            border: none !important;
            padding: 0;
        }

        .footer { 
            position: fixed; 
            bottom: -10px; 
            left: 0;
            right: 0;
            width: 100%; 
            text-align: right; 
            font-size: 8.5px; 
            color: #94a3b8; 
            border-top: 1px solid #e2e8f0; 
            padding-top: 4px; 
        }
    </style>
</head>
<body>

    @php
        // Helper Base64 Gambar untuk Logo
        if (!function_exists('getSmartBase64Image')) {
            function getSmartBase64Image($fileNames) {
                if (empty($fileNames)) return null;
                $names = is_array($fileNames) ? $fileNames : [$fileNames];
                
                $searchFolders = [
                    public_path('img/'),
                    public_path('storage/'),
                    public_path('ruangan/'),
                    public_path('/'),
                    storage_path('app/public/'),
                ];

                foreach ($names as $name) {
                    if (empty($name)) continue;
                    foreach ($searchFolders as $folder) {
                        $fullPath = rtrim($folder, '/') . '/' . ltrim($name, '/');
                        if (file_exists($fullPath) && !is_dir($fullPath)) {
                            $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                            if ($ext === 'jpg') $ext = 'jpeg';
                            $imgData = file_get_contents($fullPath);
                            return 'data:image/' . $ext . ';base64,' . base64_encode($imgData);
                        }
                    }
                }
                return null;
            }
        }

        // Ambil Base64 Logo
        $logoJateng = getSmartBase64Image(['logo-jateng.png', 'logo_jateng.png', 'logo-jateng.jpg']);
        $logoSmk9   = getSmartBase64Image(['logo-smk9.png', 'logo_smk9.png', 'logo_smk.png', 'logo-smk.png']);
    @endphp

    <table class="kop-surat">
        <tr>
            <td class="kop-logo">
                @if($logoJateng)
                    <img src="{{ $logoJateng }}" alt="Logo Pemprov Jateng">
                @else
                    <div style="width: 55px; height: 55px; border: 1px solid #cbd5e1; line-height: 55px; font-size: 8px; margin: 0 auto; text-align: center;">LOGO JATENG</div>
                @endif
            </td>
            <td class="kop-teks">
                <span style="font-size: 12px; font-weight: bold; text-transform: uppercase;">PEMERINTAH PROVINSI JAWA TENGAH</span><br>
                <span style="font-size: 12px; font-weight: bold; text-transform: uppercase;">DINAS PENDIDIKAN DAN KEBUDAYAAN</span><br>
                <span style="font-size: 15px; font-weight: 800; color: #000; text-transform: uppercase;">SEKOLAH MENENGAH KEJURUAN NEGERI 9 SEMARANG</span><br>
                <span style="font-size: 9.5px; color: #333;">Jl. Peterongan Sari No.2, Peterongan, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50242</span><br>
                <span style="font-size: 9.5px; color: #333;">Telepon: (024) 8311535 | Email: sekolah@smkn9semarang.sch.id | Website: www.smkn9semarang.sch.id</span>
            </td>
            <td class="kop-logo">
                @if($logoSmk9)
                    <img src="{{ $logoSmk9 }}" alt="Logo SMKN 9">
                @else
                    <div style="width: 55px; height: 55px; border: 1px solid #cbd5e1; line-height: 55px; font-size: 8px; margin: 0 auto; text-align: center;">LOGO SMK 9</div>
                @endif
            </td>
        </tr>
    </table>

    <div class="judul-laporan">
        <h2>Laporan Inventaris Keseluruhan</h2>
        <p>Sistem Informasi Manajemen Aset — Dicetak pada: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    @foreach($ruangans as $ruang)
        <div class="ruangan-title">
            LOKASI: {{ $ruang->nama_ruangan }} (Kode: {{ $ruang->kode_ruangan ?? '-' }})
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-kode">Kode Barang</th>
                    <th class="col-nama">Nama Barang</th>
                    <th class="col-merk">Merk</th>
                    <th class="col-spek">Spesifikasi</th>
                    <th class="col-jml">Jml</th>
                    <th class="col-kondisi">Kondisi</th>
                    <th class="col-ket">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ruang->barangs as $index => $barang)
                    <tr>
                        <td class="col-no">{{ $index + 1 }}</td>
                        <td class="col-kode">{{ $barang->kode_barang ?? '-' }}</td>
                        <td class="col-nama"><strong>{{ $barang->nama_barang }}</strong></td>
                        <td class="col-merk">{{ $barang->merk ?? '-' }}</td>
                        <td class="col-spek">{!! !empty($barang->spesifikasi) ? nl2br(e($barang->spesifikasi)) : '-' !!}</td>
                        <td class="col-jml">{{ $barang->jumlah }}</td>
                        <td class="col-kondisi">
                            @php
                                $kondisi = strtolower(trim($barang->kondisi ?? ''));
                                $classBadge = 'badge-baik';
                                if (str_contains($kondisi, 'ringan')) {
                                    $classBadge = 'badge-rusak-ringan';
                                } elseif (str_contains($kondisi, 'rusak')) {
                                    $classBadge = 'badge-rusak';
                                }
                            @endphp
                            <span class="badge {{ $classBadge }}">
                                {{ $barang->kondisi }}
                            </span>
                        </td>
                        <td class="col-ket">{{ !empty($barang->keterangan) && $barang->keterangan !== '-' ? $barang->keterangan : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; font-style: italic; color: #94a3b8; padding: 12px;">
                            Tidak ada barang yang terdaftar di ruangan ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

    <table class="ttd-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Kepala SMKN 9 Semarang</strong>
                <br><br><br><br>
                <strong><u>( .................................................. )</u></strong><br>
                NIP. ..............................................
            </td>
            <td>
                Semarang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                Pengelola Inventaris Aset,<br><br>
                <br><br><br><br>
                <strong><u>( .................................................. )</u></strong><br>
                NIP. ..............................................
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen dicetak otomatis oleh Sistem Inventaris SMKN 9 Semarang pada {{ date('d-m-Y H:i') }} WIB
    </div>

</body>
</html>