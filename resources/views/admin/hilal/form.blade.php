@extends('admin.layout')
@section('title', $hilal ? 'Edit Informasi Hilal' : 'Tambah Informasi Hilal')
@section('page-title', $hilal ? 'Edit Informasi Hilal' : 'Tambah Informasi Hilal')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <form method="POST"
              action="{{ $hilal ? route('admin.hilal.update', $hilal) : route('admin.hilal.store') }}"
              enctype="multipart/form-data"
              class="space-y-5">
            @csrf
            @if($hilal) @method('PUT') @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $hilal?->title) }}" required
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                       placeholder="Contoh: Laporan Rukyatul Hilal Ramadan 1447 H"/>
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue resize-none"
                          placeholder="Deskripsi singkat (opsional)">{{ old('description', $hilal?->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Terbit <span class="text-red-500">*</span></label>
                <input type="date" name="published_at" value="{{ old('published_at', $hilal?->published_at?->format('Y-m-d')) }}" required
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"/>
                @error('published_at')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Cover PDF (thumbnail) — this is what shows on the clickable card in Box 2 --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Cover PDF (Gambar)</label>
                <p class="text-xs text-gray-400 mb-3">Gambar ini yang tampil sebagai <em>cover</em> di kotak "Dokumen PDF" pada halaman publik. Diklik pengguna untuk membuka PDF di jendela pop-up. Berbeda dari galeri di bawah.</p>
                <div class="w-40">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-3 text-center hover:border-bmkg-blue transition-colors cursor-pointer aspect-[3/4] flex flex-col items-center justify-center overflow-hidden relative"
                         onclick="document.getElementById('thumbnail').click()">
                        <div id="preview-area-thumbnail" class="{{ $hilal?->thumbnail ? 'hidden' : '' }}">
                            <svg class="w-6 h-6 text-gray-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-xs text-gray-500">Cover PDF</p>
                        </div>
                        <img id="preview-img-thumbnail" src="{{ $hilal?->thumbnail ? asset('storage/'.$hilal->thumbnail) : '' }}"
                             class="{{ $hilal?->thumbnail ? '' : 'hidden' }} w-full h-full object-cover absolute inset-0"/>
                    </div>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="hidden"
                           onchange="previewFile(this,'preview-img-thumbnail','preview-area-thumbnail')"/>
                    @error('thumbnail')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Gallery images (up to 2) — separate from the PDF cover above --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Gambar Galeri (maks. 2, opsional)</label>
                <p class="text-xs text-gray-400 mb-3">Ditampilkan sebagai galeri (dengan tombol navigasi) di kotak "Peta / Gambar Hilal" pada halaman publik. Tidak dipakai sebagai cover PDF.</p>
                <div class="grid grid-cols-2 gap-3 max-w-xs">
                    @foreach([1 => ['image_2', $hilal?->image_2], 2 => ['image_3', $hilal?->image_3]] as $num => [$field, $current])
                        <div>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-3 text-center hover:border-bmkg-blue transition-colors cursor-pointer aspect-[3/4] flex flex-col items-center justify-center overflow-hidden relative"
                                 onclick="document.getElementById('{{ $field }}').click()">
                                <div id="preview-area-{{ $field }}" class="{{ $current ? 'hidden' : '' }}">
                                    <svg class="w-6 h-6 text-gray-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-xs text-gray-500">Galeri {{ $num }} (opsional)</p>
                                </div>
                                <img id="preview-img-{{ $field }}" src="{{ $current ? asset('storage/'.$current) : '' }}"
                                     class="{{ $current ? '' : 'hidden' }} w-full h-full object-cover absolute inset-0"/>
                            </div>
                            <input type="file" id="{{ $field }}" name="{{ $field }}" accept="image/*" class="hidden"
                                   onchange="previewFile(this,'preview-img-{{ $field }}','preview-area-{{ $field }}')"/>
                            @error($field)<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- PDF file --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">File PDF</label>
                @if($hilal && $hilal->file_path)
                    <div class="flex items-center gap-2 mb-2 p-2.5 bg-red-50 border border-red-100 rounded-lg">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                        <span class="text-xs text-red-700 truncate">File PDF sudah ada. Upload baru untuk mengganti.</span>
                        <a href="{{ asset('storage/'.$hilal->file_path) }}" target="_blank" class="ml-auto text-xs text-bmkg-blue hover:underline shrink-0">Lihat</a>
                    </div>
                @endif
                <input type="file" name="pdf_file" accept="application/pdf"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-bmkg-blue file:font-medium hover:file:bg-blue-100 transition-colors"/>
                <p class="text-xs text-gray-400 mt-1">Maks. 20MB. Pengguna dapat klik cover untuk membuka PDF ini.</p>
                @error('pdf_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">URL Eksternal (opsional)</label>
                <input type="url" name="external_url" value="{{ old('external_url', $hilal?->external_url) }}"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                       placeholder="https://..."/>
                <p class="text-xs text-gray-400 mt-1">Gunakan jika PDF dihosting di tempat lain. Diabaikan jika file PDF diupload.</p>
            </div>

            <div class="flex items-center gap-3">
                <input type="hidden" name="is_active" value="0"/>
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $hilal?->is_active ?? true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue"/>
                <label for="is_active" class="text-sm text-gray-700">Tampilkan di halaman publik</label>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.hilal.index') }}"
                   class="flex-1 text-center border border-gray-300 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit"
                        class="flex-1 bg-bmkg-blue text-white text-sm font-semibold py-2.5 rounded-lg hover:opacity-90">
                    {{ $hilal ? 'Simpan Perubahan' : 'Tambah Informasi Hilal' }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewFile(input, imgId, areaId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById(imgId);
            const area = document.getElementById(areaId);
            img.src = e.target.result;
            img.classList.remove('hidden');
            if (area) area.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
