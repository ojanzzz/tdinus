<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Sertifikat;
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
            'notes' => 'nullable|string|max:500'
        ]);

        $status = $request->status;
        $notes = $request->notes ?: ($status === 'paid' ? 'Dikonfirmasi admin' : 'Dibatalkan admin');

        $payment->update([
            'status' => $status,
            'notes' => $notes
        ]);

        if ($status === 'paid') {
            // Create sertifikat in_progress if not exists
            if (!$payment->user->sertifikats()->where('pelatihan_id', $payment->pelatihan_id)->exists()) {
                Sertifikat::create([
                    'user_id' => $payment->user_id,
                    'pelatihan_id' => $payment->pelatihan_id,
                    'status' => 'in_progress',
                    'issue_date' => now(),
                    'notes' => 'Auto-created after payment confirmation: ' . $notes
                ]);
            }
        } elseif ($status === 'rejected') {
            // Delete related sertifikat if exists
            Sertifikat::where('user_id', $payment->user_id)
                ->where('pelatihan_id', $payment->pelatihan_id)
                ->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diupdate ke ' . $status,
            'new_status' => $status,
            'notes' => $notes
        ]);
    }
}

