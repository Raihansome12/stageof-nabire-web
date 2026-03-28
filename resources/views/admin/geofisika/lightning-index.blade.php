@extends('admin.layout')
@section('title', 'Peta Sambaran Petir')
@section('page-title', 'Peta Sambaran Petir')

@section('content')

@php $bulkRoute = 'admin.lightning.bulk-destroy'; $entityName = 'periode petir'; @endphp
@include('admin.partials.bulk-bar')
<div class="flex items-center justify-end mb-6">
    <a href="{{ route('admin.lightning.create') }}"
       class="inline-flex items-center gap-2 bg-bmkg-blue text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:opacity-90">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Periode
    </a>
</div>

@if($periods->isEmpty())
    <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center text-gray-400">
        Belum ada data periode petir.
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm overflow-x-auto">
        <table class="w-full text-sm min-w-max">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 w-10"><input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)" class="rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue cursor-pointer"/></th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Label</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Tipe</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Bulan/Tahun</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Periode</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Peta</th>
                    <th class="text-right px-4 py-3 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($periods as $period)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" class="row-cb rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue cursor-pointer"
                                   value="{{ $period->id }}"/>
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $period->label }}</td>
                        <td class="px-4 py-3">
                            @php
                                $typeColors = ['dasarian'=>'blue','bulanan'=>'indigo','weekly'=>'teal'];
                                $color = $typeColors[$period->type] ?? 'gray';
                            @endphp
                            @php
                                $badgeClass = match($period->type) {
                                    'dasarian' => 'bg-blue-100 text-blue-700',
                                    'bulanan'  => 'bg-indigo-100 text-indigo-700',
                                    default    => 'bg-teal-100 text-teal-700',
                                };
                            @endphp
                            <span class="inline-block text-xs px-2 py-0.5 rounded-full {{ $badgeClass }} font-medium capitalize">
                                {{ $period->type }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ \Carbon\Carbon::create($period->year, $period->month)->isoFormat('MMMM YYYY') }}
                        </td>
                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($period->start_date)->format('d M') }}
                            –
                            {{ \Carbon\Carbon::parse($period->end_date)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3">
                            @if($period->map)
                                <img src="{{ asset('storage/'.$period->map->image_path) }}"
                                     class="h-10 w-16 object-cover rounded border border-gray-200" alt="Peta"/>
                            @else
                                <span class="text-xs text-gray-400 italic">Belum ada</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.lightning.edit', $period) }}"
                                   class="text-xs px-3 py-1.5 bg-blue-50 text-blue-700 font-medium rounded-lg hover:bg-blue-100">Edit</a>
                                <button onclick="confirmDelete('{{ route('admin.lightning.destroy', $period) }}')"
                                        class="text-xs px-3 py-1.5 bg-red-50 text-red-600 font-medium rounded-lg hover:bg-red-100">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $periods->links() }}</div>
@endif
@endsection

@push('scripts')
@include('admin.partials.bulk-js')
@endpush
