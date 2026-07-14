@extends('admin.layout')
@section('title', 'Akun Admin')
@section('page-title', 'Akun Admin')

@section('content')
<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-gray-500">Kelola akun yang bisa masuk ke panel admin ini.</p>
    <a href="{{ route('admin.users.create') }}"
       class="inline-flex items-center gap-2 bg-bmkg-blue text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-blue-800 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Akun
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr class="text-left text-gray-500 text-xs uppercase tracking-wider">
                <th class="px-6 py-3">Nama</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3">Peran</th>
                <th class="px-6 py-3">Dibuat</th>
                <th class="px-6 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $user)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-6 py-3.5 font-medium text-gray-800">
                        {{ $user->name }}
                        @if($user->id === auth()->id())
                            <span class="text-xs text-gray-400">(Anda)</span>
                        @endif
                    </td>
                    <td class="px-6 py-3.5 text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-3.5">
                        @if($user->is_admin)
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Admin</span>
                        @else
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Staf</span>
                        @endif
                    </td>
                    <td class="px-6 py-3.5 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-3.5 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">Edit</a>
                            @if($user->id !== auth()->id())
                                <button onclick="confirmDelete('{{ route('admin.users.destroy', $user) }}')"
                                        class="px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-red-600 hover:bg-red-100 transition-colors">Hapus</button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada akun.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
