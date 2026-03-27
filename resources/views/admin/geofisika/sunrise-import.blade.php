@extends('admin.layout')
@section('title', 'Import CSV - Terbit Terbenam Matahari')
@section('page-title', 'Import CSV Terbit-Terbenam Matahari')

@section('content')
<div class="max-w-3xl space-y-6">

    {{-- Back link --}}
    <a href="{{ route('admin.sunrise.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-bmkg-blue transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Daftar Data TTM
    </a>

    {{-- ── STEP 1: Download Template ──────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-amber-50">
            <div class="w-7 h-7 rounded-full bg-amber-500 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
            <div>
                <h2 class="font-semibold text-gray-800">Unduh Template CSV</h2>
                <p class="text-xs text-gray-500 mt-0.5">Download template yang sudah memiliki format dan kolom yang benar</p>
            </div>
        </div>
        <div class="p-6">
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                <div class="flex-1">
                    <p class="text-sm text-gray-600 mb-3">
                        Template berisi contoh data untuk bulan berjalan ({{ now()->isoFormat('MMMM YYYY') }})
                        dengan semua kolom yang diperlukan. Isi data sesuai format, lalu upload kembali.
                    </p>
                    {{-- Column reference table --}}
                    <div class="rounded-xl border border-gray-200 overflow-hidden">
                        <table class="w-full text-xs">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left px-3 py-2 font-semibold text-gray-600 border-b border-gray-200">Kolom</th>
                                    <th class="text-left px-3 py-2 font-semibold text-gray-600 border-b border-gray-200">Format</th>
                                    <th class="text-left px-3 py-2 font-semibold text-gray-600 border-b border-gray-200">Contoh</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @php
                                    $cols = [
                                        ['location',         'Teks',         'Nabire'],
                                        ['date',             'YYYY-MM-DD',   date('Y-m-d')],
                                        ['dawn_time',        'HH:MM',        '05:10'],
                                        ['sunrise_time',     'HH:MM',        '05:32'],
                                        ['azimuth_sunrise',  'Angka (derajat)', '65'],
                                        ['transit_time',     'HH:MM',        '11:45'],
                                        ['transit_altitude', 'Angka/teks',   '75.3S'],
                                        ['sunset_time',      'HH:MM',        '17:58'],
                                        ['azimuth_sunset',   'Angka (derajat)', '295'],
                                        ['dusk_time',        'HH:MM',        '18:20'],
                                    ];
                                @endphp
                                @foreach($cols as [$col, $fmt, $ex])
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 font-mono text-bmkg-blue font-medium">{{ $col }}</td>
                                        <td class="px-3 py-2 text-gray-500">{{ $fmt }}</td>
                                        <td class="px-3 py-2 text-gray-700">{{ $ex }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.sunrise.template') }}"
                       class="flex flex-col items-center gap-2 bg-amber-50 border-2 border-amber-200 hover:border-amber-400 hover:bg-amber-100 transition-colors rounded-xl p-5 text-center group">
                        <svg class="w-10 h-10 text-amber-500 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-xs font-semibold text-amber-700">Unduh Template</span>
                        <span class="text-xs text-amber-500">template_ttm_{{ now()->format('Y_m') }}.csv</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ── STEP 2: Fill & Upload ───────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-blue-50">
            <div class="w-7 h-7 rounded-full bg-bmkg-blue text-white flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
            <div>
                <h2 class="font-semibold text-gray-800">Upload File CSV</h2>
                <p class="text-xs text-gray-500 mt-0.5">Setelah mengisi template, upload file CSV di sini</p>
            </div>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.sunrise.import.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Drag-drop upload zone --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">File CSV <span class="text-red-500">*</span></label>
                    <div id="dropZone"
                         class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:border-bmkg-blue hover:bg-blue-50 transition-all duration-200"
                         onclick="document.getElementById('csv_file').click()"
                         ondragover="handleDragOver(event)"
                         ondragleave="handleDragLeave(event)"
                         ondrop="handleDrop(event)">
                        <div id="dropContent">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-600">Klik atau seret file CSV ke sini</p>
                            <p class="text-xs text-gray-400 mt-1">Format: .csv — Maks. 2MB</p>
                        </div>
                        <div id="fileSelected" class="hidden">
                            <svg class="w-10 h-10 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p id="fileName" class="text-sm font-semibold text-green-700"></p>
                            <p id="fileSize" class="text-xs text-gray-400 mt-0.5"></p>
                            <button type="button" onclick="clearFile(event)"
                                    class="mt-2 text-xs text-red-500 hover:text-red-700 underline">Ganti file</button>
                        </div>
                    </div>
                    <input type="file" id="csv_file" name="csv_file" accept=".csv,text/csv" class="hidden"
                           onchange="handleFileSelect(this)"/>
                    @error('csv_file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Conflict mode --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jika data sudah ada (lokasi + tanggal sama)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-start gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-bmkg-blue transition-colors has-[:checked]:border-bmkg-blue has-[:checked]:bg-blue-50">
                            <input type="radio" name="conflict_mode" value="skip" checked
                                   class="mt-0.5 text-bmkg-blue focus:ring-bmkg-blue"/>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Lewati (Skip)</p>
                                <p class="text-xs text-gray-500 mt-0.5">Data yang sudah ada tidak akan diubah. Baris baru tetap ditambahkan.</p>
                            </div>
                        </label>
                        <label class="flex items-start gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-orange-400 transition-colors has-[:checked]:border-orange-400 has-[:checked]:bg-orange-50">
                            <input type="radio" name="conflict_mode" value="replace"
                                   class="mt-0.5 text-orange-500 focus:ring-orange-400"/>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Timpa (Replace)</p>
                                <p class="text-xs text-gray-500 mt-0.5">Data yang sudah ada akan diperbarui dengan data dari CSV.</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Preview rows (JS populated) --}}
                <div id="previewSection" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Preview (5 baris pertama)</label>
                    <div class="rounded-xl border border-gray-200 overflow-x-auto">
                        <table class="w-full text-xs min-w-max">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr id="previewHead"></tr>
                            </thead>
                            <tbody id="previewBody" class="divide-y divide-gray-100"></tbody>
                        </table>
                    </div>
                </div>

                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <a href="{{ route('admin.sunrise.index') }}"
                       class="flex-1 text-center border border-gray-300 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" id="submitBtn" disabled
                            class="flex-1 bg-bmkg-blue text-white text-sm font-semibold py-2.5 rounded-lg hover:opacity-90 transition-opacity disabled:opacity-40 disabled:cursor-not-allowed">
                        Import Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Tips ───────────────────────────────────────────────────────────── --}}
    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
        <h3 class="text-sm font-semibold text-bmkg-blue mb-3 flex items-center gap-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            Petunjuk Pengisian CSV
        </h3>
        <ul class="text-xs text-blue-800 space-y-1.5 list-none">
            <li class="flex items-start gap-2"><span class="text-blue-400 mt-0.5">▸</span> Satu file CSV bisa berisi <strong>banyak lokasi sekaligus</strong> — cukup isi kolom <code class="bg-blue-100 px-1 rounded">location</code> berbeda di setiap baris.</li>
            <li class="flex items-start gap-2"><span class="text-blue-400 mt-0.5">▸</span> Format tanggal wajib <strong>YYYY-MM-DD</strong> (contoh: 2026-04-01). Format lain akan ditolak.</li>
            <li class="flex items-start gap-2"><span class="text-blue-400 mt-0.5">▸</span> Format waktu wajib <strong>HH:MM</strong> atau <strong>HH:MM:SS</strong> (contoh: 05:32 atau 05:32:00).</li>
            <li class="flex items-start gap-2"><span class="text-blue-400 mt-0.5">▸</span> Kolom <code class="bg-blue-100 px-1 rounded">azimuth_sunrise</code> dan <code class="bg-blue-100 px-1 rounded">azimuth_sunset</code> harus berupa angka bulat (derajat).</li>
            <li class="flex items-start gap-2"><span class="text-blue-400 mt-0.5">▸</span> Baris yang kosong atau header yang berulang akan diabaikan secara otomatis.</li>
            <li class="flex items-start gap-2"><span class="text-blue-400 mt-0.5">▸</span> Simpan file dari Excel sebagai <strong>CSV UTF-8</strong> (bukan CSV biasa) agar karakter khusus tidak rusak.</li>
        </ul>
    </div>

</div>
@endsection

@push('scripts')
<script>
// ── File handling ─────────────────────────────────────────────────────────────
function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        showFile(input.files[0]);
        parseCSVPreview(input.files[0]);
    }
}

function showFile(file) {
    document.getElementById('dropContent').classList.add('hidden');
    document.getElementById('fileSelected').classList.remove('hidden');
    document.getElementById('fileName').textContent = file.name;
    document.getElementById('fileSize').textContent = (file.size / 1024).toFixed(1) + ' KB';
    document.getElementById('submitBtn').disabled = false;
}

function clearFile(e) {
    e.stopPropagation();
    document.getElementById('csv_file').value = '';
    document.getElementById('dropContent').classList.remove('hidden');
    document.getElementById('fileSelected').classList.add('hidden');
    document.getElementById('previewSection').classList.add('hidden');
    document.getElementById('submitBtn').disabled = true;
}

// ── Drag & drop ───────────────────────────────────────────────────────────────
function handleDragOver(e) {
    e.preventDefault();
    document.getElementById('dropZone').classList.add('border-bmkg-blue', 'bg-blue-50');
}
function handleDragLeave(e) {
    document.getElementById('dropZone').classList.remove('border-bmkg-blue', 'bg-blue-50');
}
function handleDrop(e) {
    e.preventDefault();
    handleDragLeave(e);
    const dt = e.dataTransfer;
    if (dt.files && dt.files[0]) {
        const input = document.getElementById('csv_file');
        // Transfer to file input via DataTransfer
        try {
            const dtz = new DataTransfer();
            dtz.items.add(dt.files[0]);
            input.files = dtz.files;
        } catch(_) {}
        showFile(dt.files[0]);
        parseCSVPreview(dt.files[0]);
    }
}

// ── CSV preview (client-side, first 5 rows) ───────────────────────────────────
function parseCSVPreview(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        let text = e.target.result;
        // Strip BOM
        if (text.charCodeAt(0) === 0xFEFF) text = text.slice(1);

        const lines = text.split(/\r?\n/).filter(l => l.trim());
        if (lines.length < 2) return;

        const head = parseCSVLine(lines[0]);
        const rows = lines.slice(1, 6); // up to 5 data rows

        // Build header
        const headRow = document.getElementById('previewHead');
        headRow.innerHTML = head.map(h =>
            `<th class="text-left px-3 py-2 font-semibold text-gray-600 whitespace-nowrap">${escHtml(h)}</th>`
        ).join('') + '<th class="px-3 py-2 text-gray-400 text-center">…</th>';

        // Build body
        const body = document.getElementById('previewBody');
        body.innerHTML = rows.map(row => {
            const cols = parseCSVLine(row);
            return '<tr class="hover:bg-gray-50">' +
                cols.map(c => `<td class="px-3 py-2 text-gray-700 whitespace-nowrap">${escHtml(c)}</td>`).join('') +
                '</tr>';
        }).join('');

        document.getElementById('previewSection').classList.remove('hidden');
    };
    reader.readAsText(file, 'UTF-8');
}

function parseCSVLine(line) {
    const result = [];
    let cur = '', inQ = false;
    for (let i = 0; i < line.length; i++) {
        const ch = line[i];
        if (ch === '"') {
            if (inQ && line[i+1] === '"') { cur += '"'; i++; }
            else inQ = !inQ;
        } else if (ch === ',' && !inQ) {
            result.push(cur.trim()); cur = '';
        } else {
            cur += ch;
        }
    }
    result.push(cur.trim());
    return result;
}

function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
</script>
@endpush
