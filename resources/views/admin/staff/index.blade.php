@extends('admin.layout')
@section('title', 'Data Pegawai')
@section('page-title', 'Data Pegawai')

@section('content')

{{-- Bulk bar --}}
@php $bulkRoute = 'admin.staff.bulk-destroy'; $entityName = 'pegawai'; @endphp
@include('admin.partials.bulk-bar')
<div class="flex items-center justify-end mb-6">
    <div class="flex items-center gap-3 text-xs text-gray-500">
        <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"
               class="rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue cursor-pointer"/>
        <label for="selectAll" class="cursor-pointer">Pilih Semua</label>
    </div>
    <a href="{{ route('admin.staff.create') }}"
       class="inline-flex items-center gap-2 bg-bmkg-blue text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:opacity-90 transition-opacity">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Pegawai
    </a>
</div>

@foreach([['kepala','Kepala'], ['fungsional','Pegawai Fungsional']] as [$roleKey, $roleLabel])
    @php $group = $staffList->where('role', $roleKey); @endphp
    <div class="mb-8">
        <h2 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
            <span class="w-1 h-5 bg-bmkg-blue rounded-full inline-block"></span>
            {{ $roleLabel }}
            <span class="text-xs text-gray-400 font-normal">({{ $group->count() }} orang)</span>
        </h2>

        @if($group->isEmpty())
            <div class="bg-white rounded-xl border border-dashed border-gray-300 p-8 text-center text-gray-400 text-sm">
                Belum ada data {{ strtolower($roleLabel) }}.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($group->sortBy('sort_order') as $staff)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col items-center text-center relative">
                        {{-- Checkbox --}}
                        <div class="absolute top-3 left-3">
                            <input type="checkbox" class="row-cb w-4 h-4 rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue cursor-pointer" value="{{ $staff->id }}"/>
                        </div>
                        {{-- Active badge --}}
                        <div class="absolute top-3 right-3">
                            @if($staff->is_active)
                                <span class="inline-flex items-center gap-1 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>Nonaktif
                                </span>
                            @endif
                        </div>

                        @if($staff->photo)
                            <img src="{{ asset('storage/'.$staff->photo) }}" alt="{{ $staff->name }}"
                                 class="w-20 h-20 rounded-full object-cover border-4 border-blue-100 mb-3"/>
                        @else
                            <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center mb-3 border-4 border-blue-200">
                                <svg class="w-9 h-9 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                        @endif

                        <h3 class="font-semibold text-gray-800 text-sm">{{ $staff->name }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">NIP. {{ $staff->nip ?? '-' }}</p>

                        <div class="flex gap-2 mt-4 w-full">
                            <a href="{{ route('admin.staff.edit', $staff) }}"
                               class="flex-1 text-center text-xs py-1.5 bg-blue-50 text-blue-700 font-medium rounded-lg hover:bg-blue-100 transition-colors">
                                Edit
                            </a>
                            <button onclick="confirmDelete('{{ route('admin.staff.destroy', $staff) }}')"
                                    class="flex-1 text-xs py-1.5 bg-red-50 text-red-600 font-medium rounded-lg hover:bg-red-100 transition-colors">
                                Hapus
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endforeach
@endsection

@push('scripts')
@include('admin.partials.bulk-js')
@endpush
