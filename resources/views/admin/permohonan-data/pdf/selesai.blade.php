<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar Permohonan Data #{{ $item->id }}</title>
    <link rel="icon" href="{{ asset('img/bmkg-logo.png') }}" type="image/png" />
    <link rel="shortcut icon" href="{{ asset('img/bmkg-logo.png') }}" type="image/png" />
    @include('admin.permohonan-data.pdf._styles')
    <style>
        .yth-table { width: 100%; margin-bottom: 14px; }
        .yth-table td { padding: 1px 0; font-size: 11pt; vertical-align: top; }
        .yth-table td.yth-label { width: 45px; }
        .yth-table td.yth-colon { width: 1px; }
    </style>
</head>
<body>

    @include('admin.permohonan-data.pdf._kop-surat')

    <footer>
        <div class="footer-title">Laporan Penyelesaian Permohonan Data</div>
        <div>
            Waktu pengajuan permohonan data
            {{ $item->created_at->setTimezone('Asia/Jayapura')->translatedFormat('d F Y') }} pukul {{ $item->created_at->setTimezone('Asia/Jayapura')->format('H:i') }} WIT
            &nbsp;·&nbsp;
            Waktu penyelesaian permohonan data
            {{ $item->selesai_at?->setTimezone('Asia/Jayapura')->translatedFormat('d F Y') ?? '-' }}
            @if($item->selesai_at) pukul {{ $item->selesai_at->setTimezone('Asia/Jayapura')->format('H:i') }} WIT @endif
            &nbsp;·&nbsp;
            <br>
            Laporan dibuat pada {{ $printedAt->setTimezone('Asia/Jayapura')->translatedFormat('d F Y') }} pukul {{ $printedAt->setTimezone('Asia/Jayapura')->format('H:i') }} WIT
        </div>
    </footer>

    <div class="align-right mb-18">Nabire, {{ $printedAt->translatedFormat('d F Y') }}</div>

    <table class="yth-table">
        <tr>
            <td class="yth-label">Yth.</td>
            <td class="yth-colon"></td>
            <td>{{ $item->nama_lengkap }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>di</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><u>Nabire</u></td>
        </tr>
    </table>

    <div class="doc-title">SURAT PENGANTAR</div>
    <div class="doc-nomor">Nomor: &nbsp;{{ $item->nomor_surat ?? '                   ' }}</div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width:28px;">No.</th>
                <th>Naskah Dinas/<br>Barang Yang Dikirimkan</th>
                <th style="width:90px;">Banyaknya</th>
                <th style="width:130px;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($item->dokumen_terkirim ?? [] as $i => $row)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $row['nama'] ?? '-' }}</td>
                    <td class="center">{{ $row['jumlah'] ?? '-' }}</td>
                    <td>{{ $row['keterangan'] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td class="center">1.</td>
                    <td>Informasi geofisika sesuai permohonan: {{ $item->jenis_data }}</td>
                    <td class="center">1 (Satu) Berkas</td>
                    <td>Untuk dipergunakan sebagaimana mestinya</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-block">
        Pengirim<br>
        Kepala Stasiun Geofisika Nabire
        <div class="ttd-space"></div>
        <div class="">{{ $namaPejabat ?? 'GEORGE F. AUGUSTO MUABUAY' }}</div>
        @if(!empty($nipPejabat))
            <div class="ttd-nip">NIP. {{ $nipPejabat }}</div>
        @endif
    </div>

</body>
</html>