@extends('layouts.app')
@section('title', $buletin->title . ' — Buletin')

@section('content')
{{-- Sub-nav --}}
<div class="border-b border-gray-200 bg-white sticky top-0 z-30 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-4 h-14">
        <a href="{{ route('publikasi') }}?tab=buletin"
           class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-bmkg-blue transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Buletin
        </a>
        <div class="h-4 w-px bg-gray-300"></div>
        <h1 class="text-sm font-semibold text-gray-700 truncate">{{ $buletin->title }}</h1>
        <a href="{{ $pdfUrl }}" download
           class="ml-auto flex-shrink-0 inline-flex items-center gap-1.5 text-xs bg-bmkg-blue text-white px-3 py-1.5 rounded-lg hover:opacity-90 transition-opacity">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Unduh
        </a>
    </div>
</div>

{{-- PDF Embed --}}
<div class="w-full bg-gray-800 h-[calc(100vh-113px)]">
    {{-- Native PDF embed (works in most desktop browsers) --}}
    <iframe src="{{ $pdfUrl }}"
            class="w-full h-full border-0"
            title="{{ $buletin->title }}">
        {{-- Fallback for browsers that can't embed PDF --}}
        <div class="flex flex-col items-center justify-center h-full text-white gap-4 p-8 text-center">
            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p class="text-gray-300">Browser Anda tidak mendukung penampil PDF bawaan.</p>
            <a href="{{ $pdfUrl }}" target="_blank"
               class="bg-bmkg-blue text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:opacity-90 transition-opacity">
                Buka PDF di Tab Baru
            </a>
        </div>
    </iframe>
</div>
@endsection
