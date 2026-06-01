<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermohonanData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $data = $request->validate([
            'status'         => 'required|in:baru,diproses,selesai,ditolak',
            'catatan_admin'  => 'nullable|string|max:1000',
        ]);

        $permohonanData->update($data);

        return redirect()->route('admin.permohonan-data.show', $permohonanData)
            ->with('success', 'Status permohonan berhasil diperbarui.');
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
