@extends('admin.layout')
@section('title', 'Kotak Saran')
@section('page-title', 'Kotak Saran')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-sm text-gray-500">Daftar komentar saran anonim dari pengguna.</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.saran.bulk-destroy') }}" class="mb-4">
    @csrf
    @method('DELETE')
    <div class="flex flex-wrap gap-2">
        <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
            Hapus Terpilih
        </button>
    </div>

    @if($suggestions->isEmpty())
        <div class="mt-4 rounded-2xl border border-dashed border-gray-300 bg-white p-12 text-center text-sm text-gray-400">
            Belum ada saran yang masuk.
        </div>
    @else
        <div class="mt-4 space-y-3">
            @foreach($suggestions as $suggestion)
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="flex items-start gap-3">
                            <input type="checkbox" name="ids[]" value="{{ $suggestion->id }}" class="mt-1 rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue">
                            <div>
                                <p class="text-sm text-gray-700">{{ $suggestion->comment }}</p>
                                <p class="mt-2 text-xs text-gray-400">{{ $suggestion->created_at->format('d M Y, H:i') }} WIT</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.saran.destroy', $suggestion) }}" class="self-start">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $suggestions->links() }}</div>
    @endif
</form>
@endsection
