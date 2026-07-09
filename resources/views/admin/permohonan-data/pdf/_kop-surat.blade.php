{{-- Kop surat BMKG — dipakai bersama oleh laporan detail pemohon & laporan selesai --}}
@php
    $logoPath = public_path('img/bmkg-logo.png');
    $logoBase64 = file_exists($logoPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
        : null;
@endphp
<div class="kop-header">
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="BMKG">
                @endif
            </td>
            <td class="kop-text">
                <div class="kop-title-1">BADAN METEOROLOGI, KLIMATOLOGI, DAN GEOFISIKA</div>
                <div class="kop-title-2">STASIUN GEOFISIKA NABIRE</div>
                <div class="kop-sub">Jl. Matoa, Kalibobo, Nabire - Papua, Kode Pos : 98818</div>
                <div class="kop-sub">Telp.: (0984) 2722437, Email: stageof.nabire@gmail.com</div>
            </td>
        </tr>
    </table>
    <div class="kop-line"></div>
</div>