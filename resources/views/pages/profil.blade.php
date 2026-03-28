@extends('layouts.app')
@section('title', 'Profil - Stasiun Geofisika Kelas III Nabire')

@section('content')
{{-- Navbar --}}
<div class="border-b border-gray-200 bg-white sticky top-0 z-30 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex gap-1 overflow-x-auto" id="geo-tabs">
            <a href="{{ route('home') }}" id="tab-beranda"
               class="flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Beranda
            </a>
            <button onclick="switchTab('profil')" id="tab-profil"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Profil Kantor
            </button>
            <button onclick="switchTab('visi-misi')" id="tab-visi-misi"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Visi dan Misi
            </button>
            <button onclick="switchTab('struktur')" id="tab-struktur"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Struktur Organisasi
            </button>
        </nav>
    </div>
</div>

<section class="py-10 lg:py-14">
    {{-- Profil Kantor --}}
    <div id="panel-profil" class="panel-section">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 py-3 mb-2 border-b border-gray-300">
                <div class="w-1 h-7 bg-teal-500 rounded-full flex-shrink-0"></div>
                <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Sejarah</h1>
            </div>
            <p class="text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi obcaecati esse voluptatibus sed, id perferendis amet suscipit? Dolorum, facere, ad ipsam nisi similique accusantium nemo magnam nulla id, repellat tempora.</p>
        </div>
    </div>

    {{-- Visi dan Misi --}}
    <div id="panel-visi-misi" class="panel-section hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 py-3 mb-2 border-b border-gray-300">
                <div class="w-1 h-7 bg-bmkg-blue rounded-full flex-shrink-0"></div>
                <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Visi</h1>
            </div>
            <p class="text-gray-500 mb-10">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <div class="flex items-center gap-3 py-3 mb-2 border-b border-gray-300">
                <div class="w-1 h-7 bg-orange-500 rounded-full flex-shrink-0"></div>
                <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Misi</h1>
            </div>
            <p class="text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        </div>
    </div>

    {{-- Struktur Organisasi --}}
    <div id="panel-struktur" class="panel-section hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @auth
                @if(auth()->user()->is_admin)
                    <div class="mb-6 flex justify-end">
                        <a href="{{ route('admin.staff.index') }}"
                           class="inline-flex items-center gap-2 text-xs bg-bmkg-blue text-white px-3 py-2 rounded-lg hover:opacity-90 transition-opacity shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Kelola Pegawai
                        </a>
                    </div>
                @endif
            @endauth

            {{-- Kepala --}}
            <div class="mb-10">
                <div class="flex items-center gap-3 py-4 mb-6 border-b border-gray-300">
                    <div class="w-1 h-7 bg-bmkg-blue rounded-full flex-shrink-0"></div>
                    <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Kepala Kantor</h1>
                </div>
                @if($staffKepala->isNotEmpty())
                    @php $kepala = $staffKepala->first(); @endphp
                    <div class="bg-white rounded-lg p-4 w-[220px] text-center shadow-sm">
                        @if($kepala->photo)
                            <img src="{{ asset('storage/'.$kepala->photo) }}" class="w-[150px] h-[200px] mx-auto rounded-lg object-cover mb-5" alt="{{ $kepala->name }}">
                        @else
                            <div class="w-24 h-24 mx-auto rounded-full bg-blue-200 flex items-center justify-center mb-3">
                                <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                        @endif
                        <h2 class="font-semibold text-gray-800">{{ $kepala->name }}</h2>
                        <p class="text-sm text-gray-500">NIP. {{ $kepala->nip ?? '-' }}</p>
                    </div>
                @else
                    <p class="text-gray-400 text-sm">Belum ada data kepala.</p>
                @endif
            </div>

            {{-- Pegawai Fungsional --}}
            <div>
                <div class="flex items-center gap-3 py-4 mb-6 border-b border-gray-300">
                    <div class="w-1 h-7 bg-orange-500 rounded-full flex-shrink-0"></div>
                    <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Pegawai Fungsional</h1>
                </div>
                @if($staffFungsional->isEmpty())
                    <p class="text-gray-400 text-sm">Belum ada data pegawai fungsional.</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($staffFungsional as $s)
                            <div class="bg-white rounded-lg p-4 w-[220px] text-center shadow">
                                @if($s->photo)
                                    <img src="{{ asset('storage/'.$s->photo) }}" class="w-[150px] h-[200px] mx-auto rounded-lg object-cover mb-5" alt="{{ $s->name }}">
                                @else
                                    <div class="w-24 h-24 mx-auto rounded-full bg-blue-200 flex items-center justify-center mb-3">
                                        <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                @endif
                                <h2 class="font-semibold text-gray-800">{{ $s->name }}</h2>
                                <p class="text-sm text-gray-500">NIP. {{ $s->nip ?? '-' }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            {{-- PPNPN --}}
            <div class="mt-10">
                <div class="flex items-center gap-3 py-4 mb-6 border-b border-gray-300">
                    <div class="w-1 h-7 bg-teal-500 rounded-full flex-shrink-0"></div>
                    <h1 class="font-heading font-bold text-3xl text-bmkg-blue">PPNPN</h1>
                </div>
                @if($staffPpnpn->isEmpty())
                    <p class="text-gray-400 text-sm">Belum ada data PPNPN.</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($staffPpnpn as $s)
                            <div class="bg-white rounded-lg p-4 w-[220px] text-center shadow">
                                @if($s->photo)
                                    <img src="{{ asset('storage/'.$s->photo) }}" class="w-[150px] h-[200px] mx-auto rounded-full object-cover mb-3" alt="{{ $s->name }}">
                                @else
                                    <div class="w-24 h-24 mx-auto rounded-full bg-blue-200 flex items-center justify-center mb-3">
                                        <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                @endif
                                <h2 class="font-semibold text-gray-800">{{ $s->name }}</h2>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<script>
    function switchTab(name) {
        document.querySelectorAll('.panel-section').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-bmkg-blue', 'text-bmkg-blue');
            btn.classList.add('border-transparent', 'text-gray-500');
        });
        const panel = document.getElementById('panel-' + name);
        if (panel) panel.classList.remove('hidden');
        const activeTab = document.getElementById('tab-' + name);
        if (activeTab) {
            activeTab.classList.add('border-bmkg-blue', 'text-bmkg-blue');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
        }
        const url = new URL(window.location.href);
        url.searchParams.set('tab', name);
        window.history.replaceState({}, '', url.toString());
    }
    (function () {
        const params = new URLSearchParams(window.location.search);
        switchTab(params.get('tab') || 'profil');
    })();
</script>
@endsection
