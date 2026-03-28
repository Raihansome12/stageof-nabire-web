@extends('admin.layout')
@section('title', 'Terbit-Terbenam Matahari')
@section('page-title', 'Terbit-Terbenam Matahari (TTM)')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <p class="text-sm text-gray-500">Kelola data terbit dan terbenam matahari per lokasi dan tanggal.</p>
    <div class="flex gap-2">
        <a href="{{ route('admin.sunrise.import') }}"
           class="inline-flex items-center gap-2 bg-amber-500 text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:opacity-90 transition-opacity">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            Import CSV
        </a>
        <a href="{{ route('admin.sunrise.create') }}"
           class="inline-flex items-center gap-2 bg-bmkg-blue text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:opacity-90 transition-opacity">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Manual
        </a>
    </div>
</div>

{{-- Import result banner --}}
@if(session('import_result'))
    @php $res = session('import_result'); @endphp
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-5">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-xl {{ $res['inserted'] > 0 ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 {{ $res['inserted'] > 0 ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-800 text-sm">Hasil Import CSV</p>
                <div class="flex flex-wrap gap-4 mt-2">
                    <span class="inline-flex items-center gap-1.5 text-xs text-green-700 bg-green-50 border border-green-100 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                        {{ $res['inserted'] }} baris berhasil
                    </span>
                    @if($res['skipped'] > 0)
                        <span class="inline-flex items-center gap-1.5 text-xs text-amber-700 bg-amber-50 border border-amber-100 px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                            {{ $res['skipped'] }} dilewati
                        </span>
                    @endif
                    @if(count($res['errors']) > 0)
                        <span class="inline-flex items-center gap-1.5 text-xs text-red-700 bg-red-50 border border-red-100 px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                            {{ count($res['errors']) }} baris gagal
                        </span>
                    @endif
                </div>
                @if(!empty($res['errors']))
                    <div class="mt-3 bg-red-50 border border-red-100 rounded-lg p-3 max-h-32 overflow-y-auto">
                        @foreach($res['errors'] as $err)
                            <p class="text-xs text-red-700">{{ $err }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

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
                        <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($row->dawn_time)->format('H:i') }}</td>
                        <td class="px-4 py-3 text-amber-600 font-medium">{{ \Carbon\Carbon::parse($row->sunrise_time)->format('H:i') }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($row->transit_time)->format('H:i') }}</td>
                        <td class="px-4 py-3 text-orange-600 font-medium">{{ \Carbon\Carbon::parse($row->sunset_time)->format('H:i') }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($row->dusk_time)->format('H:i') }}</td>
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
