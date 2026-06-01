@extends('admin.layout')
@section('title', 'Detail Permohonan #' . $item->id)
@section('page-title', 'Detail Permohonan')

@section('content')

@php $badge = $item->badgeStatus(); @endphp

{{-- Flash --}}
@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 mb-4 text-sm">
        {{ session('success') }}
    </div>
@endif

<div class="mb-4">
    <a href="{{ route('admin.permohonan-data.index') }}"
       class="text-sm text-bmkg-blue hover:underline flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Daftar
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Left: Detail info ── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Header card --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $item->nama_lengkap }}</h2>
                    <p class="text-gray-500 text-sm mt-0.5">{{ $item->instansi }}</p>
                </div>
                <div class="flex gap-2 flex-wrap">
                    <span class="text-xs px-3 py-1 rounded-full font-medium
                        {{ $item->jenis_permohonan === 'pnbp' ? 'bg-purple-100 text-purple-700' : 'bg-teal-100 text-teal-700' }}">
                        {{ $item->labelJenisPermohonan() }}
                    </span>
                    <span class="text-xs px-3 py-1 rounded-full font-medium {{ $badge['class'] }}">
                        {{ $badge['label'] }}
                    </span>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3">
                Dikirim: {{ $item->created_at->format('d M Y, H:i') }} WIT &nbsp;·&nbsp; ID #{{ $item->id }}
            </p>
        </div>

        {{-- Identitas pemohon --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <span class="w-1 h-5 bg-bmkg-blue rounded-full inline-block"></span>
                Identitas Pemohon
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                <div>
                    <dt class="text-gray-400 text-xs uppercase tracking-wide">Nama Lengkap</dt>
                    <dd class="text-gray-800 font-medium mt-0.5">{{ $item->nama_lengkap }}</dd>
                </div>
                <div>
                    <dt class="text-gray-400 text-xs uppercase tracking-wide">NIK</dt>
                    <dd class="text-gray-800 font-medium mt-0.5">{{ $item->nik ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-400 text-xs uppercase tracking-wide">No. HP</dt>
                    <dd class="mt-0.5">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_hp) }}"
                           target="_blank"
                           class="text-green-600 font-medium hover:underline">
                            {{ $item->no_hp }}
                        </a>
                    </dd>
                </div>
                <div>
                    <dt class="text-gray-400 text-xs uppercase tracking-wide">Email</dt>
                    <dd class="text-gray-800 font-medium mt-0.5">
                        @if($item->email)
                            <a href="mailto:{{ $item->email }}" class="text-bmkg-blue hover:underline">{{ $item->email }}</a>
                        @else
                            —
                        @endif
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-gray-400 text-xs uppercase tracking-wide">Instansi</dt>
                    <dd class="text-gray-800 font-medium mt-0.5">{{ $item->instansi }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-gray-400 text-xs uppercase tracking-wide">Alamat</dt>
                    <dd class="text-gray-800 font-medium mt-0.5">{{ $item->alamat ?: '—' }}</dd>
                </div>
            </dl>
        </div>

        {{-- Detail permohonan --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <span class="w-1 h-5 bg-bmkg-blue rounded-full inline-block"></span>
                Detail Permohonan
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                <div>
                    <dt class="text-gray-400 text-xs uppercase tracking-wide">Jenis Permohonan</dt>
                    <dd class="text-gray-800 font-medium mt-0.5">{{ $item->labelJenisPermohonan() }}</dd>
                </div>
                @if($item->lingkup_kegiatan)
                <div>
                    <dt class="text-gray-400 text-xs uppercase tracking-wide">Lingkup Kegiatan</dt>
                    <dd class="text-gray-800 font-medium mt-0.5 capitalize">{{ $item->lingkup_kegiatan }}</dd>
                </div>
                @endif
                <div class="sm:col-span-2">
                    <dt class="text-gray-400 text-xs uppercase tracking-wide">Jenis Data yang Diminta</dt>
                    <dd class="text-gray-800 font-medium mt-0.5">{{ $item->jenis_data }}</dd>
                </div>
            </dl>
        </div>

        {{-- Dokumen --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <span class="w-1 h-5 bg-bmkg-blue rounded-full inline-block"></span>
                Dokumen Terlampir
            </h3>
            @php
                $docs = [
                    ['label' => 'Surat Permohonan Informasi', 'field' => 'file_surat_permohonan'],
                    ['label' => 'Surat Pengantar',             'field' => 'file_surat_pengantar'],
                    ['label' => 'Surat Pernyataan',            'field' => 'file_surat_pernyataan'],
                    ['label' => 'Proposal Penelitian',         'field' => 'file_proposal'],
                ];
                $hasDocs = collect($docs)->some(fn($d) => $item->{$d['field']});
            @endphp
            @if(!$hasDocs)
                <p class="text-sm text-gray-400 italic">Tidak ada dokumen terlampir.</p>
            @else
                <ul class="space-y-2">
                    @foreach($docs as $doc)
                        @if($item->{$doc['field']})
                            <li class="flex items-center justify-between text-sm">
                                <span class="text-gray-700">{{ $doc['label'] }}</span>
                                <a href="{{ asset('storage/' . $item->{$doc['field']}) }}"
                                   target="_blank"
                                   class="text-xs px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 font-medium">
                                    Lihat / Unduh
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>

    </div>

    {{-- ── Right: Status update ── --}}
    <div class="space-y-5">

        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Ubah Status & Catatan</h3>

            <form method="POST" action="{{ route('admin.permohonan-data.update', $item) }}">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                        <select name="status" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-bmkg-blue focus:border-bmkg-blue">
                            <option value="baru"     {{ $item->status === 'baru'     ? 'selected' : '' }}>Baru</option>
                            <option value="diproses" {{ $item->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai"  {{ $item->status === 'selesai'  ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak"  {{ $item->status === 'ditolak'  ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Catatan Admin</label>
                        <textarea name="catatan_admin" rows="4"
                                  class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-bmkg-blue focus:border-bmkg-blue"
                                  placeholder="Catatan internal (tidak terlihat oleh pemohon)…">{{ old('catatan_admin', $item->catatan_admin) }}</textarea>
                        @error('catatan_admin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                            class="w-full bg-bmkg-blue text-white py-2 rounded-lg text-sm font-medium hover:opacity-90 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Quick contact --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-700 mb-3">Hubungi Pemohon</h3>
            <div class="space-y-2">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_hp) }}"
                   target="_blank"
                   class="flex items-center gap-2 w-full bg-green-500 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-green-600 transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.104.551 4.075 1.517 5.784L.057 23.7a.5.5 0 00.613.614l5.96-1.456A11.943 11.943 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.89 0-3.662-.523-5.174-1.435l-.37-.222-3.837.938.956-3.818-.244-.386A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                    </svg>
                    WhatsApp
                </a>
                @if($item->email)
                <a href="mailto:{{ $item->email }}"
                   class="flex items-center gap-2 w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Email
                </a>
                @endif
            </div>
        </div>

        {{-- Danger zone --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="font-semibold text-red-600 mb-3 text-sm">Hapus Permohonan</h3>
            <form method="POST" action="{{ route('admin.permohonan-data.destroy', $item) }}"
                  onsubmit="return confirm('Hapus permohonan ini secara permanen?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full bg-red-50 text-red-600 border border-red-200 py-2 rounded-lg text-sm font-medium hover:bg-red-100 transition">
                    Hapus Permanen
                </button>
            </form>
        </div>

    </div>
</div>

@endsection
