@extends('admin.layout')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    @php
        $cards = [
            ['label' => 'Total Pegawai',     'value' => \App\Models\Staff::count(),          'color' => 'blue',   'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['label' => 'Buletin',           'value' => \App\Models\Publication::where('type','buletin')->count(), 'color' => 'indigo', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ['label' => 'Artikel',           'value' => \App\Models\Artikel::count(),         'color' => 'teal',   'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
            ['label' => 'Berita/Pengumuman', 'value' => \App\Models\InformasiPublik::count(), 'color' => 'rose',  'icon' => 'M3 12h4l5-4v8l-5-4H3zM16 10a2 2 0 010 4m2-6a5 5 0 010 8'],
            
        ];
        $colorMap = [
            'blue'   => ['bg' => 'bg-blue-50',   'icon' => 'text-blue-600',   'val' => 'text-blue-700'],
            'indigo' => ['bg' => 'bg-indigo-50', 'icon' => 'text-indigo-600', 'val' => 'text-indigo-700'],
            'teal'   => ['bg' => 'bg-teal-50',   'icon' => 'text-teal-600',   'val' => 'text-teal-700'],
            'amber'  => ['bg' => 'bg-amber-50',  'icon' => 'text-amber-600',  'val' => 'text-amber-700'],
            'rose'   => ['bg' => 'bg-rose-50',   'icon' => 'text-rose-500',   'val' => 'text-rose-700'],
        ];
    @endphp
    @foreach($cards as $card)
        @php $c = $colorMap[$card['color']]; @endphp
        <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 {{ $c['bg'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold {{ $c['val'] }}">{{ $card['value'] }}</div>
                <div class="text-xs text-gray-500 mt-0.5">{{ $card['label'] }}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-bold text-gray-700 mb-4">Akses Cepat</h2>
        <div class="grid grid-cols-2 gap-3">
            @php
                $links = [
                    [
                        'href' => route('admin.staff.create'),
                        'label' => 'Pegawai Baru',
                        'color' => 'bg-blue-600',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'
                    ],
                    [
                        'href' => route('admin.buletin.create'),
                        'label' => 'Buletin Baru',
                        'color' => 'bg-indigo-600',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-4H5m14 8H5M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'
                    ],
                    [
                        'href' => route('admin.artikel.create'),
                        'label' => 'Artikel Baru',
                        'color' => 'bg-teal-600',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>'
                    ],
                    [
                        'href' => route('admin.gempa.create'),
                        'label' => 'Gempa Bumi',
                        'color' => 'bg-orange-800',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>'
                    ],
                    [
                        'href' => route('admin.sunrise.create'),
                        'label' => 'Data TTM',
                        'color' => 'bg-orange-400',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>'
                    ],
                    [
                        'href' => route('admin.lightning.create'),
                        'label' => 'Data Petir',
                        'color' => 'bg-yellow-300',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>'
                    ],
                    [
                        'href' => route('admin.informasi-publik.create'),
                        'label' => 'Berita/Pengumuman',
                        'color' => 'bg-rose-500',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h4l5-4v8l-5-4H3zM16 10a2 2 0 010 4m2-6a5 5 0 010 8"/>'
                    ],
                ];
            @endphp

            @foreach($links as $link)
                <a href="{{ $link['href'] }}"
                class="{{ $link['color'] }} flex items-center gap-2 text-white text-sm font-medium rounded-lg px-4 py-2.5 hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $link['icon'] !!}
                    </svg>
                    <span class="flex-1 text-left">
                        {{ $link['label'] }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-bold text-gray-700 mb-4">Informasi Sistem</h2>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-500">Login sebagai</span>
                <span class="font-medium text-gray-800">{{ auth()->user()->name }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-500">Email</span>
                <span class="font-medium text-gray-800">{{ auth()->user()->email }}</span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-500">Gempa Bumi Signifikan</span>
                <span class="font-medium text-gray-800">{{ \App\Models\Earthquake::count() }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-gray-500">Periode Petir Tersimpan</span>
                <span class="font-medium text-gray-800">{{ \App\Models\LightningPeriod::count() }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
