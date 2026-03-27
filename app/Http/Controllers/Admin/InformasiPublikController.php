<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiPublik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiPublikController extends Controller
{
    public function index()
    {
        $beritas     = InformasiPublik::berita()->latest('published_at')->paginate(10, ['*'], 'berita');
        $pengumumans = InformasiPublik::pengumuman()->latest('published_at')->paginate(10, ['*'], 'pengumuman');
        return view('admin.informasi-publik.index', compact('beritas', 'pengumumans'));
    }

    public function create(Request $request)
    {
        $type = $request->input('type', 'berita');
        return view('admin.informasi-publik.form', ['item' => null, 'type' => $type]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type'         => 'required|in:berita,pengumuman',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'published_at' => 'required|date',
            'is_active'    => 'boolean',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('informasi-publik', 'public');
        }

        InformasiPublik::create($data);

        return redirect()->route('admin.informasi-publik.index')
            ->with('success', ucfirst($data['type']) . ' berhasil ditambahkan.');
    }

    public function edit(InformasiPublik $informasiPublik)
    {
        return view('admin.informasi-publik.form', [
            'item' => $informasiPublik,
            'type' => $informasiPublik->type,
        ]);
    }

    public function update(Request $request, InformasiPublik $informasiPublik)
    {
        $data = $request->validate([
            'type'         => 'required|in:berita,pengumuman',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'published_at' => 'required|date',
            'is_active'    => 'boolean',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('photo')) {
            if ($informasiPublik->photo) {
                Storage::disk('public')->delete($informasiPublik->photo);
            }
            $data['photo'] = $request->file('photo')->store('informasi-publik', 'public');
        }

        $informasiPublik->update($data);

        return redirect()->route('admin.informasi-publik.index')
            ->with('success', ucfirst($data['type']) . ' berhasil diperbarui.');
    }

    public function destroy(InformasiPublik $informasiPublik)
    {
        if ($informasiPublik->photo) {
            Storage::disk('public')->delete($informasiPublik->photo);
        }
        $informasiPublik->delete();

        return redirect()->route('admin.informasi-publik.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
