@extends('admin.layout')
@section('title', $user ? 'Edit Akun' : 'Tambah Akun')
@section('page-title', $user ? 'Edit Akun' : 'Tambah Akun')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <form method="POST"
              action="{{ $user ? route('admin.users.update', $user) : route('admin.users.store') }}"
              class="space-y-5">
            @csrf
            @if($user) @method('PUT') @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user?->name) }}" required
                       autocomplete="off"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent"/>
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user?->email) }}" required
                       autocomplete="off"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent"/>
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Password @if(!$user) <span class="text-red-500">*</span> @endif
                </label>
                <input type="password" name="password" autocomplete="new-password"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent"
                       placeholder="{{ $user ? 'Kosongkan jika tidak ingin mengubah' : 'Minimal 8 karakter' }}"/>
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" autocomplete="new-password"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent"/>
            </div>

            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $user?->is_admin) ? 'checked' : '' }}
                       class="w-4 h-4 rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue"/>
                <span class="text-sm text-gray-700">Jadikan administrator (akses penuh ke panel ini)</span>
            </label>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.users.index') }}"
                   class="flex-1 text-center px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-bmkg-blue text-white rounded-lg text-sm font-medium hover:bg-blue-800 transition-colors">
                    {{ $user ? 'Simpan Perubahan' : 'Buat Akun' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
