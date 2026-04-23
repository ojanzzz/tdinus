<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\Payment;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PelatihanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $available = Pelatihan::where('status', true)->latest()->get();
        $completed = $user->payments()
            ->with(['pelatihan', 'sertifikat'])
            ->latest()
            ->get();

        return view('member.pelatihan.index', compact('available', 'completed'));
    }

    public function konfirmasi(Pelatihan $pelatihan)
    {
        $user = Auth::user();

        // Check if already has payment for this pelatihan
        if ($user->payments()->where('pelatihan_id', $pelatihan->id)->exists()) {
            return redirect('/member/pelatihan')->with('error', 'Anda sudah memulai pembayaran untuk pelatihan ini.');
        }

        return view('member.pelatihan.konfirmasi', compact('pelatihan'));
    }

    public function take(Request $request, Pelatihan $pelatihan)
    {
        $request->validate([
            'phone' => 'required|string|min:10',
            'address' => 'required|string',
            'selected_services' => 'required|array',
        ]);

        $user = Auth::user();
        DB::beginTransaction();

        try {
            $payment = Payment::create([
                'user_id' => $user->id,
                'pelatihan_id' => $pelatihan->id,
                'amount' => $pelatihan->price,
                'status' => 'pending',
                'phone' => $request->phone,
                'address' => $request->address,
                'selected_services' => json_encode($request->selected_services),
            ]);

            DB::commit();

            return redirect()->route('member.payments.show', $payment)
                ->with('success', 'Pendaftaran pelatihan berhasil! Silakan lakukan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mendaftar pelatihan. Silakan coba lagi.');
        }
    }
}

