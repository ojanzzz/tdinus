<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberUserController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'member')
            ->when(request('search'), function($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('email', 'like', '%' . request('search') . '%');
            })
            ->latest()
            ->get();

        $sertifikats = Sertifikat::with(['user', 'pelatihan'])
            ->whereIn('status', ['pending', 'in_progress'])
            ->get();

        $completedSertifikats = Sertifikat::with(['user', 'pelatihan'])
            ->whereIn('status', ['completed', 'issued'])
            ->get();

        return view('admin.members.index', [
            'members' => $members,
            'sertifikats' => $sertifikats,
            'completedSertifikats' => $completedSertifikats,
        ]);
    }

    public function create()
    {
        return view('admin.members.create', [
            'services' => Service::pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:4'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'selected_services' => ['nullable', 'array'],
            'selected_services.*' => ['exists:services,id'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'member',
            'phone' => $data['phone'],
            'address' => $data['address'],
            'selected_services' => $data['selected_services'],
        ]);

        return redirect()->route('admin.members.index')
            ->with('success', 'Member berhasil ditambahkan.');
    }

    public function confirmSertifikat(Sertifikat $sertifikat)
    {
        if ($sertifikat->status !== 'pending') {
            return back()->with('error', 'Sertifikat hanya dapat dikonfirmasi jika berstatus menunggu konfirmasi.');
        }

        $sertifikat->update(['status' => 'in_progress']);

        return back()->with('success', 'Pelatihan berhasil dikonfirmasi.');
    }

    public function rejectSertifikat(Sertifikat $sertifikat)
    {
        if ($sertifikat->status !== 'pending') {
            return back()->with('error', 'Sertifikat hanya dapat ditolak jika berstatus menunggu konfirmasi.');
        }

        $sertifikat->update(['status' => 'revoked']);

        return back()->with('success', 'Pelatihan berhasil ditolak.');
    }

    public function updateSertifikatStatus(Request $request, Sertifikat $sertifikat)
    {
        $request->validate([
            'status' => ['required', 'in:pending,in_progress'],
        ]);

        $sertifikat->update(['status' => $request->status]);

        return back()->with('success', 'Status pelatihan berhasil diupdate.');
    }

    public function edit(User $member)
    {
        return view('admin.members.edit', [
            'member' => $member,
            'services' => Service::pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, User $member)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $member->id],
            'password' => ['nullable', 'confirmed', 'string', 'min:4'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'selected_services' => ['nullable', 'array'],
            'selected_services.*' => ['exists:services,id'],
        ]);

        $member->update($data);

        return redirect()->route('admin.members.index')
            ->with('success', 'Member berhasil diperbarui.');
    }

    public function destroy(User $member)
    {
        if ($member->role !== 'member') {
            abort(404);
        }

        $member->delete();

        return redirect()->route('admin.members.index')
            ->with('success', 'Member berhasil dihapus.');
    }
}

