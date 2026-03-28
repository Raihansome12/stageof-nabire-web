@extends('admin.layout')
@section('title', 'Data Gempa Bumi')
@section('page-title', 'Gempa Bumi')

@section('content')

{{-- Bulk bar --}}
@php $bulkRoute = 'admin.gempa.bulk-destroy'; $entityName = 'data gempa'; @endphp
@include('admin.partials.bulk-bar')

<div class="flex flex-wrap items-center justify-end gap-3 mb-5">
    <a href="{{ route('admin.gempa.create') }}"
       class="inline-flex items-center gap-2 bg-bmkg-blue text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:opacity-90">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Data Gempa
    </a>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.gempa.index') }}"
      class="bg-white rounded-2xl shadow-sm p-4 mb-5 flex flex-wrap gap-3 items-end">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Lokasi / Keterangan</label>
        <input type="text" name="search" value="{{ request('search') }}"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue w-52"
               placeholder="Cari lokasi..."/>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Magnitudo</label>
        <select name="mag" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue bg-white">
            <option value="">Semua</option>
            <option value="gte5" {{ request('mag') === 'gte5' ? 'selected' : '' }}>≥ 5.0 SR</option>
            <option value="lt5"  {{ request('mag') === 'lt5'  ? 'selected' : '' }}>&lt; 5.0 SR</option>
        </select>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
        <input type="number" name="year" value="{{ request('year') }}" min="2000" max="2100"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue w-28"
               placeholder="{{ date('Y') }}"/>
    </div>
    <button type="submit" class="bg-bmkg-blue text-white text-sm font-medium px-4 py-2 rounded-lg hover:opacity-90">Filter</button>
    <a href="{{ route('admin.gempa.index') }}" class="text-sm text-gray-500 hover:text-gray-700 py-2">Reset</a>
</form>

@if($earthquakes->isEmpty())
    <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center text-gray-400">
        Tidak ada data gempa ditemukan.
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 w-10">
                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"
                               class="rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue cursor-pointer"/>
                    </th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Waktu (UTC)</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Lokasi</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Mag.</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600 hidden sm:table-cell">Kedalaman</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600 hidden lg:table-cell">Koordinat</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600 hidden xl:table-cell">Dirasakan</th>
                    <th class="text-right px-4 py-3 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($earthquakes as $eq)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" class="row-cb rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue cursor-pointer"
                                   value="{{ $eq->id }}"/>
                        </td>
                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                            {{ $eq->occurred_at->format('d M Y') }}<br>
                            <span class="text-xs text-gray-400">{{ $eq->occurred_at->format('H:i:s') }}</span>
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-800 max-w-xs">
                            <div class="line-clamp-2">{{ $eq->location_description }}</div>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $magClass = $eq->magnitude >= 5
                                    ? 'bg-red-100 text-red-700'
                                    : ($eq->magnitude >= 4 ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700');
                            @endphp
                            <span class="inline-block font-bold text-xs px-2.5 py-1 rounded-lg {{ $magClass }}">
                                {{ $eq->magnitude }} SR
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600 hidden sm:table-cell whitespace-nowrap">{{ $eq->depth_km }} km</td>
                        <td class="px-4 py-3 text-gray-500 text-xs hidden lg:table-cell whitespace-nowrap">
                            {{ number_format(abs($eq->latitude),3) }}° {{ $eq->latitude < 0 ? 'LS':'LU' }},
                            {{ number_format(abs($eq->longitude),3) }}° BT
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs hidden xl:table-cell max-w-xs">
                            <div class="line-clamp-2">{{ $eq->felt_intensity ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.gempa.edit', $eq) }}"
                                   class="text-xs px-3 py-1.5 bg-blue-50 text-blue-700 font-medium rounded-lg hover:bg-blue-100">Edit</a>
                                <button onclick="confirmDelete('{{ route('admin.gempa.destroy', $eq) }}')"
                                        class="text-xs px-3 py-1.5 bg-red-50 text-red-600 font-medium rounded-lg hover:bg-red-100">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $earthquakes->links() }}</div>
@endif

@push('scripts')
@include('admin.partials.bulk-js')
@endpush
@endsection
