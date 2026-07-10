@extends('admin.layout')
@section('title', $earthquake ? 'Edit Data Gempa' : 'Tambah Data Gempa')
@section('page-title', $earthquake ? 'Edit Data Gempa' : 'Tambah Data Gempa')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <form method="POST"
              action="{{ $earthquake ? route('admin.gempa.update', $earthquake) : route('admin.gempa.store') }}"
              class="space-y-5">
            @csrf
            @if($earthquake) @method('PUT') @endif

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Waktu Kejadian (WIT) <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="occurred_at" required
                           value="{{ old('occurred_at', $earthquake?->occurred_at?->setTimezone('Asia/Jayapura')->format('Y-m-d\TH:i')) }}"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"/>
                    @error('occurred_at')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Magnitudo (SR) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="magnitude" step="0.1" min="0" max="10" required
                           value="{{ old('magnitude', $earthquake?->magnitude) }}"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                           placeholder="5.2"/>
                    @error('magnitude')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Deskripsi Lokasi <span class="text-red-500">*</span>
                </label>
                <input type="text" name="location_description" required
                       value="{{ old('location_description', $earthquake?->location_description) }}"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                       placeholder="Contoh: 45 km Barat Daya Nabire, Papua Tengah"/>
                @error('location_description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Kedalaman (km) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="depth_km" min="0" required
                           value="{{ old('depth_km', $earthquake?->depth_km) }}"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                           placeholder="10"/>
                    @error('depth_km')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Lintang (°) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="latitude" step="0.00001" min="-90" max="90" required
                           value="{{ old('latitude', $earthquake?->latitude) }}"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                           placeholder="-3.37000"/>
                    <p class="text-xs text-gray-400 mt-1">Negatif = LS, Positif = LU</p>
                    @error('latitude')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Bujur (°) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="longitude" step="0.00001" min="-180" max="180" required
                           value="{{ old('longitude', $earthquake?->longitude) }}"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                           placeholder="135.50000"/>
                    <p class="text-xs text-gray-400 mt-1">Selalu positif untuk BT</p>
                    @error('longitude')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Dirasakan (MMI)</label>
                <input type="text" name="felt_intensity"
                       value="{{ old('felt_intensity', $earthquake?->felt_intensity) }}"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                       placeholder="Contoh: II–III MMI di Nabire"/>
                @error('felt_intensity')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Potensi</label>
                <input type="text" name="potensi"
                       value="{{ old('potensi', $earthquake?->potensi) }}"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                       placeholder="Contoh: Tidak berpotensi tsunami"/>
                @error('potensi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">URL Shakemap (opsional)</label>
                <input type="url" name="shakemap_image"
                       value="{{ old('shakemap_image', $earthquake?->shakemap_image) }}"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                       placeholder="https://..."/>
                @error('shakemap_image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Live map preview --}}
            <div class="border-t border-gray-100 pt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pratinjau Koordinat</label>
                <div id="coordMap" class="w-full h-48 rounded-xl border border-gray-200 overflow-hidden bg-gray-100">
                    <div id="coordMapPlaceholder" class="h-full flex items-center justify-center text-gray-400 text-sm">
                        Isi lintang & bujur untuk pratinjau peta
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.gempa.index') }}"
                   class="flex-1 text-center border border-gray-300 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 bg-bmkg-blue text-white text-sm font-semibold py-2.5 rounded-lg hover:opacity-90">
                    {{ $earthquake ? 'Simpan Perubahan' : 'Tambah Data' }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let coordMap  = null;
let coordMarker = null;

function initCoordMap(lat, lng) {
    const placeholder = document.getElementById('coordMapPlaceholder');
    if (placeholder) placeholder.remove();

    if (!coordMap) {
        coordMap = L.map('coordMap', { zoomControl: true, attributionControl: false });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(coordMap);
    }

    const latlng = [parseFloat(lat), parseFloat(lng)];
    coordMap.setView(latlng, 8);

    if (coordMarker) {
        coordMarker.setLatLng(latlng);
    } else {
        coordMarker = L.circleMarker(latlng, {
            radius: 10, color: '#1d4ed8', fillColor: '#3b82f6', fillOpacity: 0.8, weight: 2
        }).addTo(coordMap);
    }
    // Force map to recalculate size after DOM reveal
    setTimeout(() => coordMap.invalidateSize(), 50);
}

function tryUpdateMap() {
    const lat = document.querySelector('[name="latitude"]').value;
    const lng = document.querySelector('[name="longitude"]').value;
    if (lat && lng && !isNaN(lat) && !isNaN(lng)) {
        initCoordMap(lat, lng);
    }
}

document.querySelector('[name="latitude"]').addEventListener('input', tryUpdateMap);
document.querySelector('[name="longitude"]').addEventListener('input', tryUpdateMap);

// Initialize with existing values on edit
(function() {
    const lat = document.querySelector('[name="latitude"]').value;
    const lng = document.querySelector('[name="longitude"]').value;
    if (lat && lng) initCoordMap(lat, lng);
})();
</script>
@endpush
@endsection
