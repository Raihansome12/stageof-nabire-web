<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detail Permohonan Data #{{ $item->id }}</title>
    <link rel="icon" href="{{ asset('img/bmkg-logo.png') }}" type="image/png" />
    <link rel="shortcut icon" href="{{ asset('img/bmkg-logo.png') }}" type="image/png" />
    @include('admin.permohonan-data.pdf._styles')
</head>
<body>

    @include('admin.permohonan-data.pdf._kop-surat')

    <footer>
        <div class="footer-title">Laporan PDF Pemohon Meminta Permohonan Data</div>
        <div>
            Pemohon mengajukan permohonan pada
            {{ $item->created_at->setTimezone('Asia/Jayapura')->translatedFormat('d F Y') }} pukul {{ $item->created_at->setTimezone('Asia/Jayapura')->format('H:i') }} WIT
            &nbsp;·&nbsp;
            Dokumen dicetak pada {{ $printedAt->setTimezone('Asia/Jayapura')->translatedFormat('d F Y') }} pukul {{ $printedAt->setTimezone('Asia/Jayapura')->format('H:i') }} WIT
        </div>
    </footer>

    <div class="doc-title">DETAIL PERMOHONAN DATA</div>
    <!-- <div class="doc-subtitle">Layanan Permohonan Data Kegeofisikaan</div> -->
    <div class="doc-nomor-1">No. Permohonan: #{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</div>

    <div class="section-title">Identitas Pemohon</div>
    <table class="info-table">
        <tr>
            <td class="label">Nama Lengkap</td><td class="colon">:</td>
            <td>{{ $item->nama_lengkap }}</td>
        </tr>
        <tr>
            <td class="label">NIK</td><td class="colon">:</td>
            <td>{{ $item->nik ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">No. HP / WhatsApp</td><td class="colon">:</td>
            <td>{{ $item->no_hp }}</td>
        </tr>
        <tr>
            <td class="label">Email</td><td class="colon">:</td>
            <td>{{ $item->email ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Instansi</td><td class="colon">:</td>
            <td>{{ $item->instansi }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td><td class="colon">:</td>
            <td>{{ $item->alamat ?: '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Detail Permohonan</div>
    <table class="info-table">
        <tr>
            <td class="label">Jenis Permohonan</td><td class="colon">:</td>
            <td>{{ $item->labelJenisPermohonan() }}</td>
        </tr>
        @if($item->lingkup_kegiatan)
        <tr>
            <td class="label">Lingkup Kegiatan</td><td class="colon">:</td>
            <td>{{ $item->labelLingkupKegiatan() }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Jenis Data yang diminta</td><td class="colon">:</td>
            <td>{{ $item->jenis_data }}</td>
        </tr>
        <tr>
            <td class="label">Status Permohonan</td><td class="colon">:</td>
            <td><span class="badge">{{ $item->badgeStatus()['label'] }}</span></td>
        </tr>
        @if($item->catatan_admin)
        <tr>
            <td class="label">Catatan Admin</td><td class="colon">:</td>
            <td>{{ $item->catatan_admin }}</td>
        </tr>
        @endif
    </table>

    <div class="section-title">Dokumen Terlampir</div>
    @php
        $docs = [
            ['label' => 'Surat Permohonan Informasi', 'field' => 'file_surat_permohonan'],
            ['label' => 'Surat Pengantar',             'field' => 'file_surat_pengantar'],
            ['label' => 'Surat Pernyataan',            'field' => 'file_surat_pernyataan'],
            ['label' => 'Proposal Penelitian',         'field' => 'file_proposal'],
        ];
        $lampiran = collect($docs)->filter(fn($d) => $item->{$d['field']})->values();
    @endphp
    @if($lampiran->isEmpty())
        <p>Tidak ada dokumen terlampir.</p>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:30px;">No.</th>
                    <th>Nama Dokumen</th>
                    <th style="width:120px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lampiran as $i => $doc)
                    <tr>
                        <td class="center">{{ $i + 1 }}</td>
                        <td>{{ $doc['label'] }}</td>
                        <td class="center">Terlampir</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>