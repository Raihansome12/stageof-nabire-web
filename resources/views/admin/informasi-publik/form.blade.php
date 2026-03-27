@extends('admin.layout')
@section('title', $item ? 'Edit ' . ucfirst($type) : 'Tambah ' . ucfirst($type))
@section('page-title', $item ? 'Edit ' . ucfirst($type) : 'Tambah ' . ucfirst($type))

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <form method="POST"
              action="{{ $item ? route('admin.informasi-publik.update', $item) : route('admin.informasi-publik.store') }}"
              enctype="multipart/form-data"
              class="space-y-5">
            @csrf
            @if($item) @method('PUT') @endif

            <input type="hidden" name="type" value="{{ $type }}"/>

            {{-- Type indicator --}}
            @if($type === 'berita')
            <div class="flex items-center gap-2 p-3 bg-blue-50 rounded-lg border border-blue-100">
            @else
            <div class="flex items-center gap-2 p-3 bg-amber-50 rounded-lg border border-amber-100">
            @endif
                <span class="text-lg">{{ $type === 'berita' ? '📰' : '📢' }}</span>
                <span class="text-sm font-medium text-gray-700">
                    {{ $type === 'berita' ? 'Berita & Siaran Pers' : 'Pengumuman' }}
                </span>
            </div>

            {{-- Photo --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto</label>
                @if($item && $item->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$item->photo) }}" class="h-40 rounded-lg object-cover border border-gray-200"/>
                        <p class="text-xs text-gray-400 mt-1">Foto saat ini. Upload baru untuk mengganti.</p>
                    </div>
                @endif
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-bmkg-blue transition-colors cursor-pointer"
                     onclick="document.getElementById('photo').click()">
                    <div id="photoArea">
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-xs text-gray-500">Klik untuk pilih foto</p>
                        <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, WebP — maks. 2MB</p>
                    </div>
                    <img id="photoPreviewImg" src="" class="hidden max-h-40 mx-auto rounded-lg mt-2"/>
                </div>
                <input type="file" id="photo" name="photo" accept="image/*" class="hidden"
                       onchange="previewFile(this,'photoPreviewImg','photoArea')"/>
                @error('photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $item?->title) }}" required
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                       placeholder="Judul {{ $type }}"/>
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="description" rows="5"
                          class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue resize-none"
                          placeholder="Isi atau ringkasan...">{{ old('description', $item?->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Terbit <span class="text-red-500">*</span></label>
                <input type="date" name="published_at"
                       value="{{ old('published_at', $item?->published_at?->format('Y-m-d') ?? date('Y-m-d')) }}"
                       required
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"/>
                @error('published_at')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3">
                <input type="hidden" name="is_active" value="0"/>
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $item?->is_active ?? true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue"/>
                <label for="is_active" class="text-sm text-gray-700">Tampilkan di halaman publik</label>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.informasi-publik.index') }}"
                   class="flex-1 text-center border border-gray-300 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit"
                        class="flex-1 bg-bmkg-blue text-white text-sm font-semibold py-2.5 rounded-lg hover:opacity-90">
                    {{ $item ? 'Simpan Perubahan' : 'Tambah ' . ucfirst($type) }}
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
            document.getElementById(imgId).src = e.target.result;
            document.getElementById(imgId).classList.remove('hidden');
            document.getElementById(areaId).classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
