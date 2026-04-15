<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $takenPelatihanIds = $user->sertifikats()->pluck('pelatihan_id')->toArray();
        $available = Pelatihan::where('status', 'active')
            ->whereNotIn('id', $takenPelatihanIds)
            ->latest()
            ->get();
        $completed = $user->sertifikats()->with('pelatihan')->latest()->get();

        return view('member.pelatihan.index', compact('available', 'completed'));
    }

    public function take(Pelatihan $pelatihan)
    {
        $user = auth()->user();

        if ($pelatihan->status !== 'active') {
            return back()->with('error', 'Pelatihan tidak tersedia.');
        }

        if ($user->sertifikats()->where('pelatihan_id', $pelatihan->id)->exists()) {
            return back()->with('error', 'Anda sudah mengambil pelatihan ini.');
        }

        $user->sertifikats()->create([
            'pelatihan_id' => $pelatihan->id,
            'issue_date' => now()->toDateString(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pelatihan berhasil diambil. Tunggu konfirmasi dari admin.');
    }
}
