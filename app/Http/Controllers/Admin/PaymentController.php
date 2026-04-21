<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'pelatihan'])
            ->latest()
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:paid,rejected',
        ]);

        if ($request->status === 'paid') {
            $payment->update([
                'status' => 'paid',
                'notes' => $request->notes ?? 'Dikonfirmasi oleh admin.',
            ]);
        } else {
            $payment->update([
                'status' => 'rejected',
                'notes' => $request->notes ?? 'Ditolak oleh admin.',
            ]);
        }

        return back()->with('success', 'Status pembayaran berhasil diupdate.');
    }
}
