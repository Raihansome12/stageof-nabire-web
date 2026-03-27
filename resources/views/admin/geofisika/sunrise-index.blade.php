@extends('admin.layout')
@section('title', 'Terbit-Terbenam Matahari')
@section('page-title', 'Terbit-Terbenam Matahari (TTM)')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <p class="text-sm text-gray-500">Kelola data terbit dan terbenam matahari per lokasi dan tanggal.</p>
    <a href="{{ route('admin.sunrise.create') }}"
       class="inline-flex items-center gap-2 bg-bmkg-blue text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:opacity-90">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Data
    </a>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.sunrise.index') }}" class="bg-white rounded-2xl shadow-sm p-4 mb-5 flex flex-wrap gap-3 items-end">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Lokasi</label>
        <input type="text" name="location" value="{{ request('location') }}" list="locationList"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue w-44"
               placeholder="Semua lokasi"/>
        <datalist id="locationList">
            @foreach($locations as $loc)
                <option value="{{ $loc }}"/>
            @endforeach
        </datalist>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Bulan</label>
        <select name="month" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue bg-white">
            <option value="">Semua</option>
            @foreach(range(1,12) as $m)
                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
        <input type="number" name="year" value="{{ request('year') }}" min="2020" max="2100"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue w-28"
               placeholder="{{ date('Y') }}"/>
    </div>
    <button type="submit" class="bg-bmkg-blue text-white text-sm font-medium px-4 py-2 rounded-lg hover:opacity-90">Filter</button>
    <a href="{{ route('admin.sunrise.index') }}" class="text-sm text-gray-500 hover:text-gray-700 py-2">Reset</a>
</form>

@if($sunrises->isEmpty())
    <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center text-gray-400">
        Tidak ada data ditemukan.
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm overflow-x-auto">
        <table class="w-full text-sm min-w-max">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Lokasi</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Fajar</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Terbit</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Transit</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Terbenam</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Senja</th>
                    <th class="text-right px-4 py-3 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($sunrises as $row)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $row->location }}</td>
                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ $row->date->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $row->dawn_time }}</td>
                        <td class="px-4 py-3 text-amber-600 font-medium">{{ $row->sunrise_time }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $row->transit_time }}</td>
                        <td class="px-4 py-3 text-orange-600 font-medium">{{ $row->sunset_time }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $row->dusk_time }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.sunrise.edit', $row) }}"
                                   class="text-xs px-3 py-1.5 bg-blue-50 text-blue-700 font-medium rounded-lg hover:bg-blue-100">Edit</a>
                                <button onclick="confirmDelete('{{ route('admin.sunrise.destroy', $row) }}')"
                                        class="text-xs px-3 py-1.5 bg-red-50 text-red-600 font-medium rounded-lg hover:bg-red-100">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $sunrises->links() }}</div>
@endif
@endsection
