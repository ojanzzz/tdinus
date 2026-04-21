<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\Payment;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        // Check if already has sertifikat for this pelatihan
        if ($user->sertifikats()->where('pelatihan_id', $pelatihan->id)->exists()) {
            return back()->with('error', 'Anda sudah mengambil pelatihan ini.');
        }

        // Check if already has payment for this pelatihan
        if ($user->payments()->where('pelatihan_id', $pelatihan->id)->exists()) {
            return back()->with('error', 'Anda sudah memulai pembayaran untuk pelatihan ini.');
        }

        if ($pelatihan->price > 0) {
            // Create payment
            $invoiceNo = 'INV-' . strtoupper(Str::random(8));
            $payment = $user->payments()->create([
                'pelatihan_id' => $pelatihan->id,
                'amount' => $pelatihan->price,
                'invoice_no' => $invoiceNo,
                'status' => 'pending',
            ]);

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'payment_id' => $payment->id,
                    'invoice_no' => $invoiceNo,
                    'message' => 'Pembayaran pelatihan berhasil dibuat.',
                    'redirect' => route('member.payment.show', $payment)
                ]);
            }

            return redirect()->route('member.payment.show', $payment)->with('success', 'Pembayaran pelatihan berhasil dibuat. Silakan lakukan pembayaran dan unggah bukti.');
        } else {
            // Free: directly create sertifikat pending
            $user->sertifikats()->create([
                'pelatihan_id' => $pelatihan->id,
                'issue_date' => now()->toDateString(),
                'status' => 'pending',
            ]);

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pelatihan gratis berhasil diambil.',
                ]);
            }

            return back()->with('success', 'Pelatihan gratis berhasil diambil. Tunggu konfirmasi dari admin.');
        }
    }
}
