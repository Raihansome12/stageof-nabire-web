@extends('layouts.app')
@section('title', $informasiPublik->title . ' - Stasiun Geofisika Kelas III Nabire')
@section('content')

@php
    $isBerita = $informasiPublik->type === 'berita';
    $label    = $isBerita ? 'Berita' : 'Pengumuman';
    $accent   = $isBerita ? 'bmkg-teal' : 'amber-600';
    $icon     = $isBerita ? '📰' : '📢';
@endphp

<div class="border-b border-gray-200 bg-white shadow-sm">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <a href="{{ route('informasi-publik', ['tab' => $informasiPublik->type]) }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-bmkg-blue hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke {{ $label }}
        </a>
    </div>
</div>

<section class="py-10 lg:py-14">
    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <p class="text-xs uppercase tracking-wider text-{{ $accent }} font-semibold mb-2">{{ $label }}</p>
        <h1 class="font-heading font-bold text-2xl sm:text-3xl text-gray-800 leading-tight">
            {{ $informasiPublik->title }}
        </h1>
        <p class="text-sm text-gray-400 mt-3">
            {{ $informasiPublik->published_at->isoFormat('D MMMM YYYY') }}
            @if(!$informasiPublik->is_active)
                <span class="ml-2 inline-flex items-center gap-1 text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Draft</span>
            @endif
        </p>

        @if($informasiPublik->photo)
            <div class="mt-6 rounded-2xl overflow-hidden shadow-sm">
                <img src="{{ asset('storage/'.$informasiPublik->photo) }}" alt="{{ $informasiPublik->title }}" class="w-full max-h-[480px] object-cover"/>
            </div>
        @endif

        <div class="mt-8 bg-white rounded-2xl shadow-sm p-6 sm:p-8">
            @if($informasiPublik->description)
                <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 leading-relaxed whitespace-pre-line">{{ $informasiPublik->description }}</div>
            @else
                <p class="text-gray-400 italic">Belum ada konten untuk {{ strtolower($label) }} ini.</p>
            @endif
        </div>

        @if($related->isNotEmpty())
            <div class="mt-12">
                <h2 class="font-heading font-bold text-xl text-bmkg-blue mb-5">{{ $label }} Lainnya</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    @foreach($related as $item)
                        <a href="{{ route('informasi-publik.show', $item) }}"
                           class="info-card bg-white rounded-2xl overflow-hidden shadow-sm flex flex-col hover:shadow-lg transition-shadow">
                            <div class="w-full h-32 bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center overflow-hidden">
                                @if($item->photo)
                                    <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->title }}" class="w-full h-full object-cover"/>
                                @else
                                    <div class="text-3xl">{{ $icon }}</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-400 mb-1">{{ $item->published_at->isoFormat('D MMM YYYY') }}</p>
                                <h3 class="font-semibold text-gray-800 text-sm line-clamp-2">{{ $item->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </article>
</section>

@endsection
