<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberSetting;
use Illuminate\Http\Request;

class MemberSettingController extends Controller
{
    public function index()
    {
        return view('admin.member-settings.index', [
            'settings' => MemberSetting::orderBy('key')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.member-settings.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:member_settings,key'],
            'value' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        MemberSetting::create($data);

        return redirect()->route('admin.member-settings.index')
            ->with('success', 'Pengaturan member berhasil ditambahkan.');
    }

    public function edit(MemberSetting $member_setting)
    {
        return view('admin.member-settings.edit', [
            'setting' => $member_setting,
        ]);
    }

    public function update(Request $request, MemberSetting $member_setting)
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:member_settings,key,' . $member_setting->id],
            'value' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        $member_setting->update($data);

        return redirect()->route('admin.member-settings.index')
            ->with('success', 'Pengaturan member berhasil diperbarui.');
    }

    public function destroy(MemberSetting $member_setting)
    {
        $member_setting->delete();

        return redirect()->route('admin.member-settings.index')
            ->with('success', 'Pengaturan member berhasil dihapus.');
    }
}
