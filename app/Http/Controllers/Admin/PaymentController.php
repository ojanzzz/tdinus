<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'notes' => 'nullable|string|max:500',
        ]);

        if ($payment->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Status pembayaran ini sudah diproses sebelumnya.',
            ], 422);
        }

        $status = $request->status;
        $notes = $request->filled('notes')
            ? $request->notes
            : ($status === 'paid' ? 'Pembayaran diterima admin.' : 'Pembayaran ditolak admin.');

        DB::transaction(function () use ($payment, $status, $notes) {
            $payment->update([
                'status' => $status,
                'notes' => $notes,
                'approved_at' => $status === 'paid' ? now() : null,
            ]);

            if ($status === 'paid') {
                Sertifikat::updateOrCreate(
                    [
                        'user_id' => $payment->user_id,
                        'pelatihan_id' => $payment->pelatihan_id,
                    ],
                    [
                        'status' => 'in_progress',
                        'issue_date' => now()->toDateString(),
                    ]
                );

                return;
            }

            Sertifikat::where('user_id', $payment->user_id)
                ->where('pelatihan_id', $payment->pelatihan_id)
                ->whereIn('status', ['pending', 'in_progress'])
                ->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diupdate ke ' . $status,
            'new_status' => $status,
            'notes' => $notes,
        ]);
    }
}
