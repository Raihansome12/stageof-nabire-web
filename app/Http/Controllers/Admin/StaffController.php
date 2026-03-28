<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index()
    {
        $staffList = Staff::orderBy('role')->orderBy('sort_order')->get();
        return view('admin.staff.index', compact('staffList'));
    }

    public function create()
    {
        return view('admin.staff.form', ['staff' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'nip'        => 'nullable|string|max:50',
            'role'       => 'required|in:kepala,fungsional,ppnpn',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'boolean',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('staff', 'public');
        }

        $data['is_active']  = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Staff::create($data);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit(Staff $staff)
    {
        return view('admin.staff.form', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'nip'        => 'nullable|string|max:50',
            'role'       => 'required|in:kepala,fungsional,ppnpn',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'boolean',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($staff->photo) {
                Storage::disk('public')->delete($staff->photo);
            }
            $data['photo'] = $request->file('photo')->store('staff', 'public');
        }

        $data['is_active']  = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $staff->update($data);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Staff $staff)
    {
        if ($staff->photo) {
            Storage::disk('public')->delete($staff->photo);
        }
        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array|min:1', 'ids.*' => 'integer|exists:staff,id']);
        $staff = \App\Models\Staff::whereIn('id', $request->ids)->get();
        foreach ($staff as $s) {
            if ($s->photo) \Illuminate\Support\Facades\Storage::disk('public')->delete($s->photo);
            $s->delete();
        }
        return redirect()->route('admin.staff.index')
            ->with('success', count($request->ids) . ' data pegawai berhasil dihapus.');
    }

}