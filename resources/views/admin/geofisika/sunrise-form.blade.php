@extends('admin.layout')
@section('title', $sunrise ? 'Edit Data TTM' : 'Tambah Data TTM')
@section('page-title', $sunrise ? 'Edit Terbit-Terbenam Matahari' : 'Tambah Terbit-Terbenam Matahari')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <form method="POST"
              action="{{ $sunrise ? route('admin.sunrise.update', $sunrise) : route('admin.sunrise.store') }}"
              class="space-y-5">
            @csrf
            @if($sunrise) @method('PUT') @endif

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="location" value="{{ old('location', $sunrise?->location ?? 'Nabire') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                           placeholder="Nabire"/>
                    @error('location')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ old('date', $sunrise?->date?->format('Y-m-d')) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"/>
                    @error('date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Waktu (Format HH:MM)</p>
                <div class="grid grid-cols-2 gap-4">
                    @php
                        $timeFields = [
                            ['dawn_time',    'Waktu Fajar (Subuh)'],
                            ['sunrise_time', 'Waktu Terbit'],
                            ['transit_time', 'Waktu Transit (Zuhur)'],
                            ['sunset_time',  'Waktu Terbenam'],
                            ['dusk_time',    'Waktu Senja (Maghrib)'],
                        ];
                    @endphp
                    @foreach($timeFields as [$field, $label])
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ $label }} <span class="text-red-500">*</span></label>
                            <input type="time" name="{{ $field }}"
                                   value="{{ old($field, $sunrise?->$field ? \Carbon\Carbon::parse($sunrise->$field)->format('H:i') : '') }}"
                                   required
                                   class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"/>
                            @error($field)<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    @endforeach

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tinggi Transit <span class="text-red-500">*</span></label>
                        <input type="text" name="transit_altitude"
                               value="{{ old('transit_altitude', $sunrise?->transit_altitude) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                               placeholder="misal: 75.3°"/>
                        @error('transit_altitude')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Azimuth (Derajat)</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Azimuth Terbit <span class="text-red-500">*</span></label>
                        <input type="number" name="azimuth_sunrise" value="{{ old('azimuth_sunrise', $sunrise?->azimuth_sunrise) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                               placeholder="65"/>
                        @error('azimuth_sunrise')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Azimuth Terbenam <span class="text-red-500">*</span></label>
                        <input type="number" name="azimuth_sunset" value="{{ old('azimuth_sunset', $sunrise?->azimuth_sunset) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                               placeholder="295"/>
                        @error('azimuth_sunset')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.sunrise.index') }}"
                   class="flex-1 text-center border border-gray-300 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit"
                        class="flex-1 bg-bmkg-blue text-white text-sm font-semibold py-2.5 rounded-lg hover:opacity-90">
                    {{ $sunrise ? 'Simpan Perubahan' : 'Tambah Data' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
