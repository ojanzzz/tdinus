<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\User;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sertifikats = Sertifikat::with(['user', 'pelatihan'])->latest()->get();
        return view('admin.sertifikat.index', ['sertifikats' => $sertifikats]);
    }

    public function create()
    {
        $users = \App\Models\User::where('role', 'member')->get(['id', 'name', 'email']);
        $pelatihans = Pelatihan::where('status', 'active')->get(['id', 'title']);
        return view('admin.sertifikat.create', compact('users', 'pelatihans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'pelatihan_id' => ['required', 'exists:pelatihans,id'],
            'issue_date' => ['required', 'date'],
            'expiry_date' => ['nullable', 'date', 'after:issue_date'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'status' => ['nullable', 'in:pending,in_progress,issued,expired,revoked'],
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/sertifikat'), $filename);
            $data['file_path'] = '/uploads/sertifikat/' . $filename;
        }

        Sertifikat::create($data);

        return redirect()->route('admin.sertifikat.index')
            ->with('success', 'Sertifikat berhasil diterbitkan.');
    }

    public function show(Sertifikat $sertifikat)
    {
        $sertifikat->load(['user', 'pelatihan']);
        return view('admin.sertifikat.show', compact('sertifikat'));
    }

    public function edit(Sertifikat $sertifikat)
    {
        $users = \App\Models\User::where('role', 'member')->get(['id', 'name', 'email']);
        $pelatihans = Pelatihan::where('status', 'active')->get(['id', 'title']);
        return view('admin.sertifikat.edit', compact('sertifikat', 'users', 'pelatihans'));
    }

    public function update(Request $request, Sertifikat $sertifikat)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'pelatihan_id' => ['required', 'exists:pelatihans,id'],
            'issue_date' => ['required', 'date'],
            'expiry_date' => ['nullable', 'date', 'after:issue_date'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'status' => ['nullable', 'in:pending,in_progress,issued,expired,revoked'],
        ]);

        if ($request->hasFile('file')) {
            $this->deleteFileIfExists($sertifikat->file_path);
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/sertifikat'), $filename);
            $data['file_path'] = '/uploads/sertifikat/' . $filename;
        }

        $sertifikat->update($data);

        return redirect()->route('admin.sertifikat.index')
            ->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function complete(Sertifikat $sertifikat)
    {
        if (! in_array($sertifikat->status, ['pending', 'in_progress'], true)) {
            return back()->with('error', 'Sertifikat hanya dapat diproses jika berstatus menunggu konfirmasi atau konfirmasi.');
        }

        $newStatus = $sertifikat->status === 'pending' ? 'in_progress' : 'issued';

        $sertifikat->update([
            'status' => $newStatus,
            'issue_date' => $sertifikat->issue_date ?? now()->toDateString(),
        ]);

        $message = $newStatus === 'in_progress' ? 'Pelatihan berhasil dikonfirmasi.' : 'Pelatihan berhasil diselesaikan dan sertifikat ditandai sebagai issued.';

        return back()->with('success', $message);
    }

    public function destroy(Sertifikat $sertifikat)
    {
        $this->deleteFileIfExists($sertifikat->file_path);
        $sertifikat->delete();

        return redirect()->route('admin.sertifikat.index')
            ->with('success', 'Sertifikat berhasil dihapus.');
    }

    private function deleteFileIfExists(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = public_path(ltrim($path, '/'));
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }

}
