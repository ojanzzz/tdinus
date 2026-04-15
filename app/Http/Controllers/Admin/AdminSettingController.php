<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        return view('admin.admin-settings.index', [
            'settings' => AdminSetting::orderBy('key')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.admin-settings.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:admin_settings,key'],
            'value' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        AdminSetting::create($data);

        return redirect()->route('admin.admin-settings.index')
            ->with('success', 'Pengaturan admin berhasil ditambahkan.');
    }

    public function edit(AdminSetting $admin_setting)
    {
        return view('admin.admin-settings.edit', [
            'setting' => $admin_setting,
        ]);
    }

    public function update(Request $request, AdminSetting $admin_setting)
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:admin_settings,key,' . $admin_setting->id],
            'value' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        $admin_setting->update($data);

        return redirect()->route('admin.admin-settings.index')
            ->with('success', 'Pengaturan admin berhasil diperbarui.');
    }

    public function destroy(AdminSetting $admin_setting)
    {
        $admin_setting->delete();

        return redirect()->route('admin.admin-settings.index')
            ->with('success', 'Pengaturan admin berhasil dihapus.');
    }
}
