@extends('admin.layout')
@section('title', $staff ? 'Edit Pegawai' : 'Tambah Pegawai')
@section('page-title', $staff ? 'Edit Pegawai' : 'Tambah Pegawai')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <form method="POST"
              action="{{ $staff ? route('admin.staff.update', $staff) : route('admin.staff.store') }}"
              enctype="multipart/form-data"
              class="space-y-5">
            @csrf
            @if($staff) @method('PUT') @endif

            {{-- Photo preview --}}
            <div class="flex flex-col items-center gap-3 pb-4 border-b border-gray-100">
                <div id="photoPreviewWrapper" class="w-24 h-24 rounded-full overflow-hidden border-4 border-blue-100 bg-blue-50 flex items-center justify-center">
                    @if($staff && $staff->photo)
                        <img id="photoPreview" src="{{ asset('storage/'.$staff->photo) }}" class="w-full h-full object-cover"/>
                    @else
                        <svg id="photoPlaceholder" class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <img id="photoPreview" src="" class="w-full h-full object-cover hidden"/>
                    @endif
                </div>
                <label class="cursor-pointer text-xs font-medium text-bmkg-blue hover:underline">
                    Pilih Foto
                    <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden"
                           onchange="previewPhoto(this)"/>
                </label>
                <p class="text-xs text-gray-400">JPG, PNG, WebP — maks. 2MB</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $staff?->name) }}" required
                       autocomplete = "off"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent"
                       placeholder="Nama lengkap pegawai"/>
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">NIP</label>
                <input type="text" name="nip" value="{{ old('nip', $staff?->nip) }}"
                       autocomplete = "off"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent"
                       placeholder="Nomor Induk Pegawai"/>
                @error('nip')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan / Peran <span class="text-red-500">*</span></label>
                <select name="role" required
                        class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent bg-white">
                    <option value="kepala"    {{ old('role', $staff?->role) === 'kepala'    ? 'selected' : '' }}>Kepala</option>
                    <option value="fungsional"{{ old('role', $staff?->role) === 'fungsional'? 'selected' : '' }}>Pegawai Fungsional</option>
                    <option value="ppnpn"     {{ old('role', $staff?->role) === 'ppnpn'     ? 'selected' : '' }}>PPNPN</option>
                </select>
                @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Urutan Tampil</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $staff?->sort_order ?? 0) }}" min="0"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent"
                       placeholder="0"/>
            </div>

            <div class="flex items-center gap-3">
                <input type="hidden" name="is_active" value="0"/>
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $staff?->is_active ?? true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue"/>
                <label for="is_active" class="text-sm text-gray-700">Tampilkan di halaman profil</label>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.staff.index') }}"
                   class="flex-1 text-center border border-gray-300 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 bg-bmkg-blue text-white text-sm font-semibold py-2.5 rounded-lg hover:opacity-90 transition-opacity">
                    {{ $staff ? 'Simpan Perubahan' : 'Tambah Pegawai' }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('photoPreview');
            const placeholder = document.getElementById('photoPlaceholder');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection