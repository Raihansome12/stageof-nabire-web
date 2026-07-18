<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermohonanData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PermohonanDataController extends Controller
{
    // ── Index ─────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = PermohonanData::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_permohonan', $request->jenis);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_lengkap', 'like', "%{$s}%")
                  ->orWhere('instansi',   'like', "%{$s}%")
                  ->orWhere('no_hp',      'like', "%{$s}%")
                  ->orWhere('jenis_data', 'like', "%{$s}%");
            });
        }

        $permohonan = $query->paginate(15)->withQueryString();
        $counts = [
            'baru'     => PermohonanData::baru()->count(),
            'total'    => PermohonanData::count(),
        ];

        return view('admin.permohonan-data.index', compact('permohonan', 'counts'));
    }

    // ── Show ──────────────────────────────────────────────────────────────────
    public function show(PermohonanData $permohonanData)
    {
        return view('admin.permohonan-data.show', ['item' => $permohonanData]);
    }

    // ── Update status + catatan ───────────────────────────────────────────────
    public function update(Request $request, PermohonanData $permohonanData)
    {
        $rules = [
            'status'         => 'required|in:baru,diproses,belum dibayar,sudah dibayar,selesai,ditolak',
            'catatan_admin'  => 'nullable|string|max:1000',
        ];

        // Ketika admin menandai permohonan "Selesai", wajib mengisi rincian
        // data/barang yang dikirimkan — dipakai sebagai isi Laporan PDF Selesai.
        if ($request->input('status') === 'selesai') {
            $rules['dokumen_terkirim']               = 'required|array|min:1';
            $rules['dokumen_terkirim.*.nama']         = 'required|string|max:255';
            $rules['dokumen_terkirim.*.jumlah']       = 'required|string|max:100';
            $rules['dokumen_terkirim.*.keterangan']   = 'nullable|string|max:255';
        }

        $data = $request->validate($rules);

        if ($data['status'] === 'selesai') {
            // Catat waktu penyelesaian hanya pada saat pertama kali menjadi "selesai"
            // agar footer laporan PDF konsisten meski disimpan ulang.
            $data['selesai_at'] = $permohonanData->selesai_at ?? Carbon::now('Asia/Jayapura');
        } else {
            $data['dokumen_terkirim'] = null;
            $data['selesai_at'] = null;
        }

        $permohonanData->update($data);

        $message = $data['status'] === 'selesai'
            ? 'Status permohonan diperbarui menjadi Selesai. Laporan PDF siap diunduh.'
            : 'Status permohonan berhasil diperbarui.';

        return redirect()->route('admin.permohonan-data.show', $permohonanData)
            ->with('success', $message);
    }

    // ── PDF: Detail Pemohon ──────────────────────────────────────────────────
    public function pdfDetail(PermohonanData $permohonanData)
    {
        Carbon::setLocale('id');

        $pdf = Pdf::loadView('admin.permohonan-data.pdf.detail', [
            'item'      => $permohonanData,
            'printedAt' => Carbon::now('Asia/Jayapura'),
        ])->setPaper('a4', 'portrait');

        return $pdf->stream("detail-permohonan-{$permohonanData->id}.pdf");
    }

    // ── PDF: Laporan Selesai / Surat Pengantar ──────────────────────────────
    public function pdfSelesai(PermohonanData $permohonanData)
    {
        abort_unless($permohonanData->status === 'selesai', 403, 'Permohonan belum berstatus Selesai.');

        Carbon::setLocale('id');

        $pdf = Pdf::loadView('admin.permohonan-data.pdf.selesai', [
            'item'      => $permohonanData,
            'printedAt' => Carbon::now('Asia/Jayapura'),
        ])->setPaper('a4', 'portrait');

        return $pdf->stream("surat-pengantar-{$permohonanData->id}.pdf");
    }

    // ── Destroy ───────────────────────────────────────────────────────────────
    public function destroy(PermohonanData $permohonanData)
    {
        foreach (['file_surat_permohonan', 'file_surat_pengantar', 'file_surat_pernyataan', 'file_proposal'] as $field) {
            if ($permohonanData->$field) {
                Storage::disk('public')->delete($permohonanData->$field);
            }
        }
        $permohonanData->delete();

        return redirect()->route('admin.permohonan-data.index')
            ->with('success', 'Permohonan berhasil dihapus.');
    }

    // ── Bulk destroy ──────────────────────────────────────────────────────────
    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array|min:1', 'ids.*' => 'integer|exists:permohonan_data,id']);

        $items = PermohonanData::whereIn('id', $request->ids)->get();
        foreach ($items as $item) {
            foreach (['file_surat_permohonan', 'file_surat_pengantar', 'file_surat_pernyataan', 'file_proposal'] as $field) {
                if ($item->$field) Storage::disk('public')->delete($item->$field);
            }
            $item->delete();
        }

        return redirect()->route('admin.permohonan-data.index')
            ->with('success', count($request->ids) . ' permohonan berhasil dihapus.');
    }
}
