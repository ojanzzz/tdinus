<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = auth()->user()->payments()->with('pelatihan')->latest()->paginate(10);

        return view('member.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        $payment->load('pelatihan');

        if (request()->wantsJson()) {
            return response()->json($payment);
        }

        return view('member.payments.show', compact('payment'));
    }

    public function uploadBukti(Request $request, Payment $payment)
    {
        if ($payment->user_id !== auth()->id() || $payment->status !== 'pending') {
            return back()->with('error', 'Tidak dapat mengunggah bukti pembayaran.');
        }

        $request->validate([
            'bukti_path' => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $file = $request->file('bukti_path');
        $path = $file->store('payments/bukti', 'public');

        $payment->update([
            'bukti_path' => $path,
            'notes' => $request->notes ?? 'Bukti pembayaran diunggah.',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu konfirmasi admin.');
    }
}
