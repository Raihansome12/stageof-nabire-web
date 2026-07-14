<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HilalBulletin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HilalController extends Controller
{
    public function index()
    {
        $hilals = HilalBulletin::latest('published_at')->paginate(12);
        return view('admin.hilal.index', compact('hilals'));
    }

    public function create()
    {
        return view('admin.hilal.form', ['hilal' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'published_at' => 'required|date',
            'is_active'    => 'boolean',
            'thumbnail'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'pdf_file'     => 'nullable|file|mimes:pdf|max:20480',
            'external_url' => 'nullable|url|max:500',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('hilal/thumbnails', 'public');
        }
        if ($request->hasFile('pdf_file')) {
            $data['file_path'] = $request->file('pdf_file')->store('hilal/pdfs', 'public');
        }

        HilalBulletin::create($data);

        return redirect()->route('admin.hilal.index')
            ->with('success', 'Informasi hilal berhasil ditambahkan.');
    }

    public function edit(HilalBulletin $hilal)
    {
        return view('admin.hilal.form', compact('hilal'));
    }

    public function update(Request $request, HilalBulletin $hilal)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'published_at' => 'required|date',
            'is_active'    => 'boolean',
            'thumbnail'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'pdf_file'     => 'nullable|file|mimes:pdf|max:20480',
            'external_url' => 'nullable|url|max:500',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('thumbnail')) {
            if ($hilal->thumbnail) Storage::disk('public')->delete($hilal->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('hilal/thumbnails', 'public');
        }
        if ($request->hasFile('pdf_file')) {
            if ($hilal->file_path) Storage::disk('public')->delete($hilal->file_path);
            $data['file_path'] = $request->file('pdf_file')->store('hilal/pdfs', 'public');
        }

        $hilal->update($data);

        return redirect()->route('admin.hilal.index')
            ->with('success', 'Informasi hilal berhasil diperbarui.');
    }

    public function destroy(HilalBulletin $hilal)
    {
        if ($hilal->thumbnail) Storage::disk('public')->delete($hilal->thumbnail);
        if ($hilal->file_path) Storage::disk('public')->delete($hilal->file_path);
        $hilal->delete();

        return redirect()->route('admin.hilal.index')
            ->with('success', 'Informasi hilal berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array|min:1', 'ids.*' => 'integer|exists:hilal_bulletins,id']);
        $items = HilalBulletin::whereIn('id', $request->ids)->get();
        foreach ($items as $item) {
            if ($item->thumbnail) Storage::disk('public')->delete($item->thumbnail);
            if ($item->file_path)  Storage::disk('public')->delete($item->file_path);
            $item->delete();
        }
        return redirect()->route('admin.hilal.index')
            ->with('success', count($request->ids) . ' data hilal berhasil dihapus.');
    }
}
