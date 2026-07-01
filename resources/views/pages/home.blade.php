@extends('layouts.app')
@section('title', 'Beranda - Stasiun Geofisika Kelas III Nabire')

@section('content')

@php
    $hasShakemap = $earthquake && !empty($earthquake->shakemap_image);
    $hasGeoData  = $earthquake && !$hasShakemap
        && $earthquake->latitude !== null
        && $earthquake->longitude !== null
        && $earthquake->magnitude !== null;
@endphp

@if($hasGeoData)
    {{-- Leaflet CSS: only needed when we render the fallback earthquake map --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endif

{{-- ═══════════════════════════════════════════════════
     SECTION 1: Terbit Terbenam Matahari Hari Ini
     ═══════════════════════════════════════════════════ --}}
<section class="py-10 lg:py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="font-heading font-bold text-2xl lg:text-3xl text-bmkg-black mb-8">
            Terbit Terbenam Matahari Hari Ini
        </h2>

        @if($sunrises->isEmpty())
            <div class="text-center text-gray-400 py-10">Data belum tersedia.</div>
        @else
            <div class="relative" x-data="sunriseSlider()" x-init="init()">
                {{-- Prev Button --}}
                <button @click="prev()"
                        class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 w-9 h-9 rounded-full bg-white border border-gray-200 flex items-center justify-center shadow-sm hover:bg-gray-50 transition">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </button>

                {{-- Track Wrapper --}}
                <div class="overflow-hidden" x-ref="wrapper">
                    <div class="flex gap-6"
                         :class="animating ? 'transition-transform duration-400 ease-in-out' : ''"
                         :style="`transform: translateX(-${offset}px)`"
                         x-ref="track"
                         @transitionend="onTransitionEnd()">

                        @foreach($sunrises as $sun)
                            <div class="info-card bg-gradient-to-br from-purple-200 via-blue-100 to-blue-200 rounded-2xl p-6 shadow-sm border border-white/60 flex-shrink-0 slider-card">
                                {{-- Header --}}
                                <div class="mb-4 border-b border-gray-300 pb-3">
                                    <p class="font-semibold text-gray-800 text-base">{{ $sun->location }}</p>
                                    <p class="text-xs text-gray-400">{{ $sun->date->format('d M Y') }}</p>
                                </div>

                                {{-- Sunrise --}}
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="shrink-0">
                                        <img src="{{ asset('img/sunrise.png') }}" alt="Terbit"
                                             class="w-10 h-10 object-contain"
                                             onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden')"/>
                                        <div class="hidden w-10 h-10 text-2xl flex items-center justify-center">🌅</div>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">Terbit</p>
                                        <p class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($sun->sunrise_time)->format('H.i') }} WIT
                                        </p>
                                    </div>
                                </div>

                                {{-- Sunset --}}
                                <div class="flex items-center gap-3">
                                    <div class="shrink-0">
                                        <img src="{{ asset('img/sunset.png') }}" alt="Terbenam"
                                             class="w-10 h-10 object-contain"
                                             onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden')"/>
                                        <div class="hidden w-10 h-10 text-2xl flex items-center justify-center">🌇</div>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">Terbenam</p>
                                        <p class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($sun->sunset_time)->format('H.i') }} WIT
                                        </p>
                                    </div>
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- Next Button --}}
                <button @click="next()"
                        class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 w-9 h-9 rounded-full bg-white border border-gray-200 flex items-center justify-center shadow-sm hover:bg-gray-50 transition">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </button>

            </div>
        @endif
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     SECTION 2: Gempa Bumi Terkini + Informasi Petir
     ═══════════════════════════════════════════════════ --}}
<section class="py-10 lg:py-14 bg-bmkg-lightblue">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Gempa Bumi Terkini --}}
            <div class="info-card bg-white rounded-2xl p-6 lg:p-8">
                <h2 class="font-heading font-bold text-2xl lg:text-3xl text-bmkg-black mb-1">
                    Gempa Bumi Terkini
                </h2>

                @if($earthquake)
                    {{-- Timestamp --}}
                    <p class="text-sm text-gray-400 mb-6">
                        {{ $earthquake->occurred_at->setTimezone('Asia/Jayapura')->format('d M Y') }}
                        &ndash;
                        {{ $earthquake->occurred_at->setTimezone('Asia/Jayapura')->format('H:i:s') }} WIT
                    </p>

                    <div class="flex flex-col sm:flex-row gap-6">

                        {{-- ShakeMap —— full URL from BMKG static CDN, or a generated map fallback --}}
                        <div class="shrink-0 w-full sm:w-52">
                            @if($hasShakemap)
                                <img src="{{ $earthquake->shakemap_image }}"
                                     alt="ShakeMap Gempa {{ $earthquake->occurred_at->setTimezone('Asia/Jayapura')->format('d M Y H:i') }} WIT"
                                     class="w-full rounded-xl object-cover border border-gray-200"
                                     loading="lazy"/>
                            @elseif($hasGeoData)
                                <div id="home-eq-map"
                                     class="w-full h-55 rounded-xl border border-gray-200 relative z-0"></div>
                            @else
                                <div class="w-full h-44 bg-gray-200 rounded-xl flex items-center justify-center text-gray-400 text-sm">
                                    <div class="text-center">
                                        <div class="text-3xl mb-2">🗺️</div>
                                        <div>ShakeMap</div>
                                    </div>
                                </div>
                            @endif
                            {{-- Wilayah --}}
                            <div class="px-2 pt-2 pb-4  border-b border-gray-300">
                                <p class="text-sm font-medium text-gray-700 text-justify">
                                    {{ $earthquake->location_description }}
                                </p>
                            </div>
                        </div>

                        {{-- Detail info --}}
                        <div class="flex-1 space-y-4">
                            {{-- Potensi (tsunami) --}}
                            @if($earthquake->potensi)
                                <div class="flex items-start">
                                    @php
                                        $isTsunami = str_contains(strtolower($earthquake->potensi), 'tsunami')
                                                  && ! str_contains(strtolower($earthquake->potensi), 'tidak');
                                    @endphp
                                    <span class="inline-flex items-center px-3.5 py-2 rounded-full text-xs font-semibold
                                        {{ $isTsunami ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $earthquake->potensi }}
                                    </span>
                                </div>
                            @endif

                            {{-- Magnitudo --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full border-2 border-red-500 flex items-center justify-center shrink-0 mt-0.5 text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 12h4l2-5 4 10 2-5h6" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700">Magnitudo:</p>
                                    <p class="text-sm text-gray-600">{{ number_format($earthquake->magnitude, 1) }}</p>
                                </div>
                            </div>

                            {{-- Kedalaman --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full border-2 border-green-600 flex items-center justify-center shrink-0 mt-0.5 text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                        <circle cx="12" cy="12" r="5" stroke-width="2"/>
                                        <circle cx="12" cy="12" r="1" stroke-width="2"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700">Kedalaman:</p>
                                    <p class="text-sm text-gray-600">{{ $earthquake->depth_km }} km</p>
                                </div>
                            </div>

                            {{-- Koordinat --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full border-2 border-orange-500 flex items-center justify-center shrink-0 mt-0.5 text-orange-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C8 2 5 5 5 9c0 5 7 13 7 13s7-8 7-13c0-4-3-7-7-7z"/>
                                        <circle cx="12" cy="9" r="2.5" fill="white"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700">Lokasi:</p>
                                    <p class="text-sm text-gray-600">
                                        {{ abs($earthquake->latitude) }}
                                        {{ $earthquake->latitude < 0 ? 'LS' : 'LU' }}
                                        &ndash;
                                        {{ abs($earthquake->longitude) }}
                                        {{ $earthquake->longitude >= 0 ? 'BT' : 'BB' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Dirasakan (MMI) --}}
                            <div>
                                <p class="text-sm font-semibold text-gray-700 mb-1">
                                    Dirasakan (Skala MMI):
                                </p>
                                @if($earthquake->felt_intensity)
                                    <div>
                                        <!-- <p class="text-sm font-semibold text-gray-700 mb-1">
                                            Dirasakan (Skala MMI):
                                        </p> -->
                                        <p class="text-sm text-gray-600">{{ $earthquake->felt_intensity }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-400 text-sm mt-4">Data gempa belum tersedia.</p>
                @endif
            </div>

            {{-- Informasi Kejadian Petir --}}
            <div class="info-card bg-white rounded-2xl p-6 lg:p-8 ">
                <h2 class="font-heading font-bold text-2xl lg:text-3xl text-bmkg-black mb-1">
                    Informasi Kejadian Petir
                </h2>

                @if($lightningInfo)
                    <p class="text-sm text-gray-400 mb-6">
                        {{ \Carbon\Carbon::create()->month($lightningInfo->month)->format('F') }}
                        {{ $lightningInfo->year }} - {{ $lightningInfo->label }}    
                    </p>
                    @if($lightningMap->image_path)
                        <div class="flex items-center justify-center bg-gray-100 rounded-xl shadow-sm">
                            <img src="{{ asset('storage/' . $lightningMap->image_path) }}"
                             alt="Peta Petir"
                             class="w-md rounded-xl object-contain border border-gray-200"/>    
                        </div>
                        
                    @else
                        <div class="w-full h-64 bg-gray-200 rounded-xl flex items-center justify-center text-gray-400">
                            <div class="text-center">
                                <div class="text-4xl mb-2">⚡</div>
                                <div class="text-sm">Peta Kerapatan Petir</div>
                            </div>
                        </div>
                    @endif
                @else
                    <p class="text-gray-400 text-sm mt-4">Data petir belum tersedia.</p>
                @endif
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     SECTION 3: Informasi Terkini (Publikasi)
     ═══════════════════════════════════════════════════ --}}
<section class="py-10 lg:py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="font-heading font-bold text-2xl lg:text-3xl text-bmkg-black text-center mb-8">
            Informasi Terkini
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Buletin Bulanan --}}
            <div class="info-card bg-white rounded-2xl overflow-hidden shadow-sm min-h-56 flex flex-col">
                @if($buletin && $buletin->thumbnail)
                    <img src="{{ asset('storage/' . $buletin->thumbnail) }}"
                         alt="{{ $buletin->title }}"
                         class="w-full h-40 object-cover"/>
                @else
                    <div class="w-full h-40 bg-gradient-to-br from-bmkg-lightblue to-blue-100 flex items-center justify-center">
                        <div class="text-4xl">📋</div>
                    </div>
                @endif
                <div class="p-6 flex flex-col flex-1 justify-between">
                    <div>
                        <span class="text-xs uppercase tracking-wider text-bmkg-teal font-semibold">Buletin Bulanan</span>
                        <h3 class="font-heading font-semibold text-gray-800 text-lg mt-1 mb-2">
                            {{ $buletin ? $buletin->title : 'Buletin Bulanan' }}
                        </h3>
                        @if($buletin && $buletin->description)
                            <p class="text-sm text-gray-500 line-clamp-2">{{ $buletin->description }}</p>
                        @endif
                    </div>
                    @if($buletin)
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-xs text-gray-400">
                                {{ $buletin->published_at->format('d M Y') }}
                            </span>
                            @if($buletin->file_path || $buletin->external_url)
                                <a href="{{ route('publikasi.pdf-viewer', $buletin) }}"
                                   target="_blank"
                                   class="text-xs font-semibold text-bmkg-blue hover:underline">
                                    Unduh →
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Berita (2 cards stacked) --}}
            <div class="space-y-4 flex flex-col">
                @forelse($beritas as $berita)
                    <div class="info-card bg-white rounded-2xl overflow-hidden shadow-sm flex-1 flex flex-col">
                        @if($berita->thumbnail)
                            <img src="{{ asset('storage/' . $berita->thumbnail) }}"
                                 alt="{{ $berita->title }}"
                                 class="w-full h-28 object-cover"/>
                        @else
                            <div class="w-full h-28 bg-gradient-to-br from-amber-50 to-orange-100 flex items-center justify-center">
                                <div class="text-3xl">📰</div>
                            </div>
                        @endif
                        <div class="p-5 flex flex-col flex-1 justify-between">
                            <div>
                                <span class="text-xs uppercase tracking-wider text-bmkg-orange font-semibold">Berita</span>
                                <h3 class="font-heading font-semibold text-gray-800 text-base mt-1">
                                    {{ $berita->title }}
                                </h3>
                                @if($berita->description)
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $berita->description }}</p>
                                @endif
                            </div>
                            <p class="text-xs text-gray-400 mt-2">{{ $berita->published_at->format('d M Y') }}</p>
                        </div>
                    </div>
                @empty
                    @for($i = 0; $i < 2; $i++)
                        <div class="info-card bg-white rounded-2xl shadow-sm flex-1 flex items-center justify-center min-h-32">
                            <span class="text-gray-400 font-heading font-semibold text-lg">Berita</span>
                        </div>
                    @endfor
                @endforelse
            </div>

        </div>
    </div>
</section>

<script>
    function sunriseSlider() {
        return {
            visible: 5,
            cardWidth: 0,
            gap: 16,
            current: 0,
            offset: 0,
            animating: false,
            totalReal: 0,

            get activeDot() {
                return ((this.current % this.totalReal) + this.totalReal) % this.totalReal;
            },

            init() {
                const track = this.$refs.track;
                const wrapper = this.$refs.wrapper;
                const realCards = [...track.querySelectorAll('.slider-card')];
                this.totalReal = realCards.length;

                // Responsive: adjust visible count
                const updateVisible = () => {
                    if (window.innerWidth < 640) this.visible = 2;
                    else if (window.innerWidth < 1024) this.visible = 3;
                    else this.visible = 5;
                };
                updateVisible();

                const setup = () => {
                    updateVisible();

                    // Remove previously cloned nodes
                    track.querySelectorAll('[data-clone]').forEach(el => el.remove());

                    // Clone last N and first N real cards
                    const clonesStart = realCards.slice(-this.visible).map(c => {
                        const cl = c.cloneNode(true);
                        cl.setAttribute('data-clone', 'start');
                        cl.setAttribute('aria-hidden', 'true');
                        return cl;
                    });
                    const clonesEnd = realCards.slice(0, this.visible).map(c => {
                        const cl = c.cloneNode(true);
                        cl.setAttribute('data-clone', 'end');
                        cl.setAttribute('aria-hidden', 'true');
                        return cl;
                    });

                    clonesStart.forEach(c => track.insertBefore(c, track.firstChild));
                    clonesEnd.forEach(c => track.appendChild(c));

                    // Read flex gap from CSS so spacing can be controlled by Tailwind classes
                    const computedTrackStyle = window.getComputedStyle(track);
                    this.gap = parseFloat(computedTrackStyle.columnGap || computedTrackStyle.gap) || 0;

                    // Calculate card width from wrapper and current gap
                    this.cardWidth = Math.floor((wrapper.offsetWidth - (this.gap * (this.visible - 1))) / this.visible);

                    // Set width on all cards (real + clones)
                    track.querySelectorAll('.slider-card, [data-clone]').forEach(card => {
                        card.style.width = this.cardWidth + 'px';
                    });

                    // Reset position to start of real cards (after prepended clones)
                    this.current = 0;
                    this.animating = false;
                    this.offset = this.visible * (this.cardWidth + this.gap);
                };

                this.$nextTick(() => {
                    setup();

                    window.addEventListener('resize', () => {
                        setup();
                    });
                });

                // Keyboard navigation
                window.addEventListener('keydown', e => {
                    if (e.key === 'ArrowLeft') this.prev();
                    if (e.key === 'ArrowRight') this.next();
                });

                // Touch swipe
                let startX = 0;
                wrapper.addEventListener('touchstart', e => {
                    startX = e.touches[0].clientX;
                }, { passive: true });
                wrapper.addEventListener('touchend', e => {
                    const diff = startX - e.changedTouches[0].clientX;
                    if (Math.abs(diff) > 40) {
                        diff > 0 ? this.next() : this.prev();
                    }
                });
            },

            next() {
                if (this.animating) return;
                this.animating = true;
                this.current++;
                this.offset += (this.cardWidth + this.gap);
            },

            prev() {
                if (this.animating) return;
                this.animating = true;
                this.current--;
                this.offset -= (this.cardWidth + this.gap);
            },

            goTo(i) {
                if (this.animating) return;
                const diff = i - this.activeDot;
                if (diff === 0) return;
                this.animating = true;
                this.current += diff;
                this.offset += diff * (this.cardWidth + this.gap);
            },

            onTransitionEnd() {
                this.animating = false;

                // Silently snap back when entering clone zone
                if (this.current >= this.totalReal) {
                    this.current = this.current % this.totalReal;
                    this.offset = (this.visible + this.current) * (this.cardWidth + this.gap);
                } else if (this.current < 0) {
                    this.current = ((this.current % this.totalReal) + this.totalReal) % this.totalReal;
                    this.offset = (this.visible + this.current) * (this.cardWidth + this.gap);
                }
            }
        }
    }
</script>

@if($hasGeoData)
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    (function () {
        const eq = {
            lat: {{ (float) $earthquake->latitude }},
            lng: {{ (float) $earthquake->longitude }},
            mag: {{ (float) $earthquake->magnitude }},
            loc: @json($earthquake->location_description),
            depth: {{ (float) $earthquake->depth_km }},
            time: @json($earthquake->occurred_at->setTimezone('Asia/Jayapura')->format('d M Y H:i')),
            mmi: '{{ $earthquake->mmi ?? "" }}'
        };

        const map = L.map('home-eq-map', {
            zoomControl: false,
            attributionControl: false,
            scrollWheelZoom: false,
            dragging: false,
            touchZoom: false,
            doubleClickZoom: false,
            boxZoom: false,
            keyboard: false
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        function markerColor(mag) {
            return mag >= 5 ? '#ef4444' : (mag >= 4 ? '#f97316' : '#22c55e');
        }

        const c = markerColor(eq.mag);
        
        // Added ${eq.mag} inside the .eq-dot div
        const html = `
            <div class="quake-epicenter" style="--eq-color: ${c}; --eq-color-soft: ${c}33;">
                <div class="eq-uncertainty"></div>
                <div class="eq-ring eq-ring-1"></div>
                <div class="eq-ring eq-ring-2"></div>
                <div class="eq-ring eq-ring-3"></div>
                <div class="eq-dot">${eq.mag}</div>
            </div>`;
        
        const icon = L.divIcon({ 
            html, 
            className: '', 
            iconSize: [70, 70], 
            iconAnchor: [35, 35], 
            popupAnchor: [0, -25] 
        });

        L.marker([eq.lat, eq.lng], { icon }).addTo(map)
            .bindPopup(`
                <div class="eq-popup">
                    <div class="eq-popup-title">${eq.loc}</div>
                    <div class="eq-popup-time">${eq.time} WIT</div>
                    <div class="eq-popup-meta">
                        <span class="eq-popup-pill">M ${eq.mag} SR</span>
                        <span class="eq-popup-pill">⬇ ${eq.depth} km</span>
                        ${eq.mmi ? `<span class="eq-popup-pill">MMI ${eq.mmi}</span>` : ''}
                    </div>
                </div>
            `, { maxWidth: 260 });

        const center = L.latLng(eq.lat, eq.lng);
        const bounds = center.toBounds(300000);

        map.fitBounds(bounds);

        setTimeout(() => {
            map.invalidateSize();
            map.fitBounds(bounds); 
        }, 150);
    })();
</script>
@endif

@endsection