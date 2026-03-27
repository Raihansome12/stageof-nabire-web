@extends('admin.layout')
@section('title', $period ? 'Edit Periode Petir' : 'Tambah Periode Petir')
@section('page-title', $period ? 'Edit Periode Petir' : 'Tambah Periode Petir')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <form method="POST"
              action="{{ $period ? route('admin.lightning.update', $period) : route('admin.lightning.store') }}"
              enctype="multipart/form-data"
              class="space-y-5">
            @csrf
            @if($period) @method('PUT') @endif

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tahun <span class="text-red-500">*</span></label>
                    <input type="number" name="year" value="{{ old('year', $period?->year ?? date('Y')) }}" required
                           min="2000" max="2100"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"/>
                    @error('year')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Bulan <span class="text-red-500">*</span></label>
                    <select name="month" required
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue bg-white">
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" {{ old('month', $period?->month) == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}
                            </option>
                        @endforeach
                    </select>
                    @error('month')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tipe Periode <span class="text-red-500">*</span></label>
                <select name="type" required
                        class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue bg-white">
                    <option value="dasarian" {{ old('type', $period?->type) === 'dasarian' ? 'selected' : '' }}>Dasarian</option>
                    <option value="bulanan"  {{ old('type', $period?->type) === 'bulanan'  ? 'selected' : '' }}>Bulanan</option>
                    <option value="weekly"   {{ old('type', $period?->type) === 'weekly'   ? 'selected' : '' }}>Mingguan</option>
                </select>
                @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Label <span class="text-red-500">*</span></label>
                <input type="text" name="label" value="{{ old('label', $period?->label) }}" required
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"
                       placeholder="Contoh: Dasarian I, Dasarian II, Bulanan Maret 2026"/>
                <p class="text-xs text-gray-400 mt-1">Gunakan format: "Dasarian I", "Dasarian II", "Dasarian III", atau "Bulanan"</p>
                @error('label')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" value="{{ old('start_date', $period?->start_date) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"/>
                    @error('start_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Selesai <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" value="{{ old('end_date', $period?->end_date) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue"/>
                    @error('end_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Map image --}}
            <div class="border-t border-gray-100 pt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Peta Sambaran Petir (Gambar)</label>
                @if($period && $period->map)
                    <div class="mb-3">
                        <img src="{{ asset('storage/'.$period->map->image_path) }}"
                             class="max-h-48 rounded-lg border border-gray-200 object-contain" alt="Peta saat ini"/>
                        <p class="text-xs text-gray-400 mt-1">Peta saat ini. Upload baru untuk mengganti.</p>
                    </div>
                @endif
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-bmkg-blue transition-colors cursor-pointer" onclick="document.getElementById('mapImage').click()">
                    <div id="mapArea">
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        <p class="text-xs text-gray-500">Klik untuk pilih gambar peta</p>
                        <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, WebP — maks. 5MB</p>
                    </div>
                    <img id="mapPreviewImg" src="" class="hidden max-h-48 mx-auto rounded-lg mt-2 object-contain"/>
                </div>
                <input type="file" id="mapImage" name="map_image" accept="image/*" class="hidden"
                       onchange="previewFile(this,'mapPreviewImg','mapArea')"/>
                @error('map_image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.lightning.index') }}"
                   class="flex-1 text-center border border-gray-300 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit"
                        class="flex-1 bg-bmkg-blue text-white text-sm font-semibold py-2.5 rounded-lg hover:opacity-90">
                    {{ $period ? 'Simpan Perubahan' : 'Tambah Periode' }}
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
