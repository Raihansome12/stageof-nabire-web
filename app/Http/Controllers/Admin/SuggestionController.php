<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function index()
    {
        $suggestions = Suggestion::latest()->paginate(20);

        return view('admin.saran.index', compact('suggestions'));
    }

    public function destroy(Suggestion $suggestion)
    {
        $suggestion->delete();

        return redirect()->route('admin.saran.index')->with('success', 'Saran berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Pilih minimal satu saran untuk dihapus.');
        }

        Suggestion::whereIn('id', $ids)->delete();

        return back()->with('success', 'Saran yang dipilih berhasil dihapus.');
    }
}
