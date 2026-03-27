@extends('admin.layout')
@section('title', 'Berita & Pengumuman')
@section('page-title', 'Berita & Pengumuman')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">Kelola berita, siaran pers, dan pengumuman.</p>
    <div class="flex gap-2">
        <a href="{{ route('admin.informasi-publik.create', ['type'=>'berita']) }}"
           class="inline-flex items-center gap-1.5 bg-bmkg-blue text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:opacity-90">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Berita
        </a>
        <a href="{{ route('admin.informasi-publik.create', ['type'=>'pengumuman']) }}"
           class="inline-flex items-center gap-1.5 bg-amber-500 text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:opacity-90">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengumuman
        </a>
    </div>
</div>

@foreach([['berita', $beritas, 'Berita & Siaran Pers', 'blue'], ['pengumuman', $pengumumans, 'Pengumuman', 'amber']] as [$typeKey, $items, $label, $color])
    <div class="mb-8">
        <h2 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
            @if($typeKey === 'berita')
                <span class="w-1 h-5 bg-blue-500 rounded-full inline-block"></span>
            @else
                <span class="w-1 h-5 bg-amber-500 rounded-full inline-block"></span>
            @endif
            {{ $label }}
        </h2>

        @if($items->isEmpty())
            <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-8 text-center text-gray-400 text-sm">
                Belum ada {{ strtolower($label) }}.
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600 w-16">Foto</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600">Judul</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden md:table-cell">Deskripsi</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden sm:table-cell">Tanggal</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-600">Status</th>
                            <th class="text-right px-5 py-3 font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($items as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3">
                                    @if($item->photo)
                                        <img src="{{ asset('storage/'.$item->photo) }}" class="w-12 h-12 object-cover rounded-lg border border-gray-200"/>
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-xl">
                                            {{ $typeKey === 'berita' ? '📰' : '📢' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-3 font-medium text-gray-800 max-w-xs">
                                    <div class="line-clamp-2">{{ $item->title }}</div>
                                </td>
                                <td class="px-5 py-3 text-gray-500 hidden md:table-cell max-w-xs">
                                    <div class="line-clamp-2">{{ $item->description ?? '-' }}</div>
                                </td>
                                <td class="px-5 py-3 text-gray-500 hidden sm:table-cell whitespace-nowrap">
                                    {{ $item->published_at->format('d M Y') }}
                                </td>
                                <td class="px-5 py-3">
                                    @if($item->is_active)
                                        <span class="inline-flex items-center gap-1 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.informasi-publik.edit', $item) }}"
                                           class="text-xs px-3 py-1.5 bg-blue-50 text-blue-700 font-medium rounded-lg hover:bg-blue-100">Edit</a>
                                        <button onclick="confirmDelete('{{ route('admin.informasi-publik.destroy', $item) }}')"
                                                class="text-xs px-3 py-1.5 bg-red-50 text-red-600 font-medium rounded-lg hover:bg-red-100">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $items->links() }}</div>
        @endif
    </div>
@endforeach
@endsection
