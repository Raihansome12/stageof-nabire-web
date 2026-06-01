@extends('admin.layout')
@section('title', $period ? 'Edit Periode Petir' : 'Tambah Periode Petir')
@section('page-title', $period ? 'Edit Periode Petir' : 'Tambah Periode Petir')

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- ── MAIN PERIOD FORM ─────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-bold text-gray-700 mb-5 flex items-center gap-2">
            <span class="w-1 h-5 bg-bmkg-blue rounded-full"></span>
            Informasi Periode
        </h2>
        <form method="POST"
              action="{{ $period ? route('admin.lightning.update', $period) : route('admin.lightning.store') }}"
              enctype="multipart/form-data"
              id="periodForm"
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
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-bmkg-blue transition-colors cursor-pointer"
                     onclick="document.getElementById('mapImage').click()">
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
                    {{ $period ? 'Simpan Perubahan' : 'Simpan & Lanjutkan' }}
                </button>
            </div>
        </form>
    </div>

    {{-- ── CHILD DATA SECTIONS (only shown when editing an existing period) ─ --}}
    @if($period)

        {{-- ── SUBDISTRICT STATS ──────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-bold text-gray-700 flex items-center gap-2">
                        <span class="w-1 h-5 bg-yellow-500 rounded-full"></span>
                        Data Kecamatan (Grafik Batang Sambaran)
                    </h2>
                    <p class="text-xs text-gray-400 mt-1">Data ini mengisi grafik "Total Kejadian Petir per Kecamatan" di halaman publik.</p>
                </div>
                <button onclick="addSubRow()"
                        class="inline-flex items-center gap-1.5 bg-yellow-500 text-white text-xs font-medium px-3 py-2 rounded-lg hover:bg-yellow-600 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Baris
                </button>
            </div>

            <form method="POST" action="{{ route('admin.lightning.stats.sync', $period) }}" id="statsForm">
                @csrf
                @method('PUT')

                <div class="overflow-x-auto">
                    <table class="w-full text-sm" id="statsTable">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="text-left px-3 py-2.5 font-semibold text-gray-600 w-12">#</th>
                                <th class="text-left px-3 py-2.5 font-semibold text-gray-600">Nama Kecamatan</th>
                                <th class="text-left px-3 py-2.5 font-semibold text-gray-600 w-40">Total Sambaran</th>
                                <th class="px-3 py-2.5 w-12"></th>
                            </tr>
                        </thead>
                        <tbody id="statsBody">
                            @forelse($period->subdistrictStats->sortByDesc('total_strikes') as $i => $stat)
                                <tr class="border-b border-gray-100 stat-row">
                                    <td class="px-3 py-2 text-gray-400 text-xs row-num">{{ $i + 1 }}</td>
                                    <td class="px-3 py-2">
                                        <input type="hidden" name="stats[{{ $i }}][id]" value="{{ $stat->id }}"/>
                                        <input type="text" name="stats[{{ $i }}][subdistrict]"
                                               value="{{ $stat->subdistrict }}" required
                                               class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                               placeholder="Nama kecamatan"/>
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="number" name="stats[{{ $i }}][total_strikes]"
                                               value="{{ $stat->total_strikes }}" required min="0"
                                               class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                               placeholder="0"/>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <button type="button" onclick="removeRow(this)"
                                                class="text-red-400 hover:text-red-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr id="statsEmpty">
                                    <td colspan="4" class="px-3 py-8 text-center text-gray-400 text-sm">
                                        Belum ada data kecamatan. Klik "Tambah Baris" untuk mulai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-yellow-500 text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-yellow-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Data Kecamatan
                    </button>
                </div>
            </form>
        </div>

        {{-- ── DAILY DENSITY ───────────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-bold text-gray-700 flex items-center gap-2">
                        <span class="w-1 h-5 bg-teal-500 rounded-full"></span>
                        Data Kerapatan Harian (Grafik Batang Harian)
                    </h2>
                    <p class="text-xs text-gray-400 mt-1">Data ini mengisi grafik "Kerapatan Sambaran Petir Harian" di halaman publik.</p>
                </div>
                <!-- <button onclick="addDailyRow()"
                        class="inline-flex items-center gap-1.5 bg-teal-500 text-white text-xs font-medium px-3 py-2 rounded-lg hover:bg-teal-600 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Hari
                </button> -->
            </div>

            <form method="POST" action="{{ route('admin.lightning.densities.sync', $period) }}" id="densityForm">
                @csrf
                @method('PUT')

                <div class="overflow-x-auto">
                    <table class="w-full text-sm" id="densityTable">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="text-left px-3 py-2.5 font-semibold text-gray-600 w-12">#</th>
                                <th class="text-left px-3 py-2.5 font-semibold text-gray-600">Tanggal</th>
                                <th class="text-left px-3 py-2.5 font-semibold text-gray-600 w-44">Total Kerapatan</th>
                                <th class="px-3 py-2.5 w-12"></th>
                            </tr>
                        </thead>
                        <tbody id="densityBody">
                            @forelse($period->densities->sortBy('date') as $i => $den)
                                <tr class="border-b border-gray-100 density-row">
                                    <td class="px-3 py-2 text-gray-400 text-xs row-num">{{ $i + 1 }}</td>
                                    <td class="px-3 py-2">
                                        <input type="hidden" name="densities[{{ $i }}][id]" value="{{ $den->id }}"/>
                                        <input type="date" name="densities[{{ $i }}][date]"
                                               value="{{ \Carbon\Carbon::parse($den->date)->format('Y-m-d') }}" required
                                               class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400"/>
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="number" name="densities[{{ $i }}][total_density]"
                                               value="{{ $den->total_density }}" required min="0" step="0.01"
                                               class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400"
                                               placeholder="0"/>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <button type="button" onclick="removeRow(this)"
                                                class="text-red-400 hover:text-red-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr id="densityEmpty">
                                    <td colspan="4" class="px-3 py-8 text-center text-gray-400 text-sm">
                                        Belum ada data harian. Klik "Tambah Hari" untuk mulai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-teal-500 text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-teal-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Data Harian
                    </button>
                </div>
            </form>
        </div>

    @else
        {{-- Hint when creating a new period --}}
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="text-sm font-medium text-blue-800">Data grafik dapat diisi setelah periode disimpan</p>
                <p class="text-xs text-blue-600 mt-1">Setelah menekan "Simpan & Lanjutkan", Anda akan dapat mengisi data kecamatan dan kerapatan harian untuk mengisi grafik di halaman publik.</p>
            </div>
        </div>
    @endif

</div>

@push('scripts')
<script>
// ── Shared helper ────────────────────────────────────────────────────────────
function removeRow(btn) {
    const row = btn.closest('tr');
    row.remove();
    renumberRows();
}

function renumberRows() {
    document.querySelectorAll('#statsBody .stat-row .row-num').forEach((el, i) => {
        el.textContent = i + 1;
        // re-index input names
        el.closest('tr').querySelectorAll('[name]').forEach(inp => {
            inp.name = inp.name.replace(/stats\[\d+\]/, `stats[${i}]`);
        });
    });
    document.querySelectorAll('#densityBody .density-row .row-num').forEach((el, i) => {
        el.textContent = i + 1;
        el.closest('tr').querySelectorAll('[name]').forEach(inp => {
            inp.name = inp.name.replace(/densities\[\d+\]/, `densities[${i}]`);
        });
    });
}

// ── Subdistrict stats ────────────────────────────────────────────────────────
function addSubRow() {
    const tbody = document.getElementById('statsBody');
    const empty = document.getElementById('statsEmpty');
    if (empty) empty.remove();

    const idx = tbody.querySelectorAll('.stat-row').length;
    const tr = document.createElement('tr');
    tr.className = 'border-b border-gray-100 stat-row';
    tr.innerHTML = `
        <td class="px-3 py-2 text-gray-400 text-xs row-num">${idx + 1}</td>
        <td class="px-3 py-2">
            <input type="hidden" name="stats[${idx}][id]" value=""/>
            <input type="text" name="stats[${idx}][subdistrict]" required
                   class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"
                   placeholder="Nama kecamatan"/>
        </td>
        <td class="px-3 py-2">
            <input type="number" name="stats[${idx}][total_strikes]" required min="0"
                   class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"
                   placeholder="0"/>
        </td>
        <td class="px-3 py-2 text-center">
            <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </td>`;
    tbody.appendChild(tr);
    tr.querySelector('input[type=text]').focus();
}

// ── Daily densities ──────────────────────────────────────────────────────────
function addDailyRow() {
    const tbody = document.getElementById('densityBody');
    const empty = document.getElementById('densityEmpty');
    if (empty) empty.remove();

    const idx = tbody.querySelectorAll('.density-row').length;
    const tr = document.createElement('tr');
    tr.className = 'border-b border-gray-100 density-row';
    tr.innerHTML = `
        <td class="px-3 py-2 text-gray-400 text-xs row-num">${idx + 1}</td>
        <td class="px-3 py-2">
            <input type="hidden" name="densities[${idx}][id]" value=""/>
            <input type="date" name="densities[${idx}][date]" required
                   class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400"/>
        </td>
        <td class="px-3 py-2">
            <input type="number" name="densities[${idx}][total_density]" required min="0" step="0.01"
                   class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400"
                   placeholder="0"/>
        </td>
        <td class="px-3 py-2 text-center">
            <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </td>`;
    tbody.appendChild(tr);
    tr.querySelector('input[type=date]').focus();
}

// ── Map image preview ────────────────────────────────────────────────────────
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

function generateDensityFromRange() {
    const start = document.querySelector('[name="start_date"]').value;
    const end   = document.querySelector('[name="end_date"]').value;

    if (!start || !end) return;

    const tbody = document.getElementById('densityBody');
    tbody.innerHTML = ''; // reset

    let current = new Date(start);
    const endDate = new Date(end);

    let i = 0;

    while (current <= endDate) {
        const dateStr = current.toISOString().split('T')[0];

        const tr = document.createElement('tr');
        tr.className = 'border-b border-gray-100 density-row';

        tr.innerHTML = `
            <td class="px-3 py-2 text-gray-400 text-xs row-num">${i + 1}</td>
            <td class="px-3 py-2">
                <input type="hidden" name="densities[${i}][id]" value=""/>
                <input type="date" name="densities[${i}][date]"
                       value="${dateStr}" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400"/>
            </td>
            <td class="px-3 py-2">
                <input type="number" name="densities[${i}][total_density]"
                       required min="0" step="0.01"
                       class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400"
                       placeholder="0"/>
            </td>
            <td class="px-3 py-2 text-center">
                <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </td>
        `;

        tbody.appendChild(tr);

        current.setDate(current.getDate() + 1);
        i++;
    }
}

document.addEventListener('DOMContentLoaded', function () {

const startInput = document.querySelector('[name="start_date"]');
const endInput   = document.querySelector('[name="end_date"]');

if (startInput && endInput) {
    startInput.addEventListener('change', generateDensityFromRange);
    endInput.addEventListener('change', generateDensityFromRange);

    // Only auto-generate if creating NEW period (no existing densities)
    // Check if there are existing density rows with IDs
    const hasExistingData = document.querySelector('input[name*="[id]"][name*="densities"]') !== null;
    if (startInput.value && endInput.value && !hasExistingData) {
        generateDensityFromRange();
    }
}

});
</script>
@endpush
@endsection
