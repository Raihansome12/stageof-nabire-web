<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublikasiController extends Controller
{
    // ── BULETIN ───────────────────────────────────────────────────────────────

    public function buletinIndex()
    {
        $buletins = Publication::buletin()->latest('published_at')->paginate(12);
        return view('admin.publikasi.buletin-index', compact('buletins'));
    }

    public function buletinCreate()
    {
        return view('admin.publikasi.buletin-form', ['buletin' => null]);
    }

    public function buletinStore(Request $request)
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

        $data['type']      = 'buletin';
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('publications/thumbnails', 'public');
        }
        if ($request->hasFile('pdf_file')) {
            $data['file_path'] = $request->file('pdf_file')->store('publications/pdfs', 'public');
        }

        Publication::create($data);

        return redirect()->route('admin.buletin.index')
            ->with('success', 'Buletin berhasil ditambahkan.');
    }

    public function buletinEdit(Publication $buletin)
    {
        return view('admin.publikasi.buletin-form', compact('buletin'));
    }

    public function buletinUpdate(Request $request, Publication $buletin)
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
            if ($buletin->thumbnail) Storage::disk('public')->delete($buletin->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('publications/thumbnails', 'public');
        }
        if ($request->hasFile('pdf_file')) {
            if ($buletin->file_path) Storage::disk('public')->delete($buletin->file_path);
            $data['file_path'] = $request->file('pdf_file')->store('publications/pdfs', 'public');
        }

        $buletin->update($data);

        return redirect()->route('admin.buletin.index')
            ->with('success', 'Buletin berhasil diperbarui.');
    }

    public function buletinDestroy(Publication $buletin)
    {
        if ($buletin->thumbnail) Storage::disk('public')->delete($buletin->thumbnail);
        if ($buletin->file_path) Storage::disk('public')->delete($buletin->file_path);
        $buletin->delete();

        return redirect()->route('admin.buletin.index')
            ->with('success', 'Buletin berhasil dihapus.');
    }

    // ── ARTIKEL ───────────────────────────────────────────────────────────────

    public function artikelIndex()
    {
        $artikels = Artikel::latest('published_at')->paginate(12);
        return view('admin.publikasi.artikel-index', compact('artikels'));
    }

    public function artikelCreate()
    {
        return view('admin.publikasi.artikel-form', ['artikel' => null]);
    }

    public function artikelStore(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'published_at' => 'required|date',
            'is_active'    => 'boolean',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('artikels', 'public');
        }

        Artikel::create($data);

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function artikelEdit(Artikel $artikel)
    {
        return view('admin.publikasi.artikel-form', compact('artikel'));
    }

    public function artikelUpdate(Request $request, Artikel $artikel)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'published_at' => 'required|date',
            'is_active'    => 'boolean',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('photo')) {
            if ($artikel->photo) Storage::disk('public')->delete($artikel->photo);
            $data['photo'] = $request->file('photo')->store('artikels', 'public');
        }

        $artikel->update($data);

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function artikelDestroy(Artikel $artikel)
    {
        if ($artikel->photo) Storage::disk('public')->delete($artikel->photo);
        $artikel->delete();

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
