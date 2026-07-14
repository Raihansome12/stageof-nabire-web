@extends('admin.layout')
@section('title', 'Token API')
@section('page-title', 'Token API')

@section('content')

@if(session('plainTextToken'))
    <div class="mb-5 bg-amber-50 border border-amber-200 rounded-2xl p-5">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-amber-900 mb-1">
                    Token "{{ session('plainTextTokenName') }}" berhasil dibuat
                </p>
                <p class="text-xs text-amber-700 mb-3">
                    Salin sekarang dan simpan (mis. di file <code>.env</code> program Python Anda). Token ini tidak akan ditampilkan lagi setelah halaman ini ditinggalkan.
                </p>
                <div class="flex gap-2">
                    <input id="plainToken" type="text" readonly value="{{ session('plainTextToken') }}"
                           class="flex-1 bg-white border border-amber-300 rounded-lg px-3 py-2 text-xs font-mono text-gray-800 select-all"/>
                    <button type="button" onclick="copyToken()"
                            class="px-3 py-2 bg-amber-500 text-white rounded-lg text-xs font-medium hover:bg-amber-600 transition-colors">
                        Salin
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function copyToken() {
            const el = document.getElementById('plainToken');
            el.select();
            navigator.clipboard.writeText(el.value);
        }
    </script>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Issue new token --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="font-bold text-gray-800 text-sm mb-4">Buat Token Baru</h2>
            <form method="POST" action="{{ route('admin.tokens.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Untuk Akun <span class="text-red-500">*</span></label>
                    <select name="user_id" required
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent bg-white">
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                    @error('user_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Token <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           autocomplete="off" placeholder="mis. vps-laptop-scraper"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent"/>
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-400 mt-1">Gunakan nama yang jelas agar mudah dikenali & dicabut nanti.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Abilities (opsional)</label>
                    <input type="text" name="abilities" value="{{ old('abilities') }}"
                           autocomplete="off" placeholder="mis. earthquakes:store"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent"/>
                    <p class="text-xs text-gray-400 mt-1">Pisahkan dengan koma. Kosongkan untuk akses penuh (*).</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kedaluwarsa (opsional)</label>
                    <input type="date" name="expires_at" value="{{ old('expires_at') }}"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-bmkg-blue focus:border-transparent"/>
                    <p class="text-xs text-gray-400 mt-1">Kosongkan agar token berlaku selamanya (sampai dicabut).</p>
                </div>

                <button type="submit"
                        class="w-full px-4 py-2.5 bg-bmkg-blue text-white rounded-lg text-sm font-medium hover:bg-blue-800 transition-colors">
                    Buat Token
                </button>
            </form>
        </div>
    </div>

    {{-- Existing tokens --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-5 py-3">Nama</th>
                        <th class="px-5 py-3">Pemilik</th>
                        <th class="px-5 py-3">Terakhir Dipakai</th>
                        <th class="px-5 py-3">Kedaluwarsa</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tokens as $token)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-5 py-3.5 font-medium text-gray-800">{{ $token->name }}</td>
                            <td class="px-5 py-3.5 text-gray-600">{{ $token->tokenable?->name ?? '—' }}</td>
                            <td class="px-5 py-3.5 text-gray-500">
                                {{ $token->last_used_at ? $token->last_used_at->diffForHumans() : 'Belum pernah' }}
                            </td>
                            <td class="px-5 py-3.5 text-gray-500">
                                {{ $token->expires_at ? $token->expires_at->format('d M Y') : 'Tidak ada' }}
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <button onclick="confirmDelete('{{ route('admin.tokens.destroy', $token) }}')"
                                        class="px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-red-600 hover:bg-red-100 transition-colors">Cabut</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center text-gray-400">Belum ada token.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
