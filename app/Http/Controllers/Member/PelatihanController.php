<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\Payment;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelatihanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $available = Pelatihan::where('status', 'active')->latest()->get();
        $payments = $user->payments()
            ->with('pelatihan')
            ->latest()
            ->get();

        $latestPayments = $payments->unique('pelatihan_id')->keyBy('pelatihan_id');
        $activePelatihans = $user->sertifikats()
            ->with('pelatihan')
            ->where('status', 'in_progress')
            ->latest()
            ->get();
        $activePelatihanIds = $activePelatihans->pluck('pelatihan_id')->all();
        $issuedPelatihanIds = $user->sertifikats()
            ->where('status', 'issued')
            ->pluck('pelatihan_id')
            ->all();

        return view('member.pelatihan.index', compact(
            'available',
            'payments',
            'latestPayments',
            'activePelatihans',
            'activePelatihanIds',
            'issuedPelatihanIds'
        ));
    }

    public function konfirmasi(Pelatihan $pelatihan)
    {
        $user = Auth::user();
        $existingPayment = $this->existingOpenPayment($user->id, $pelatihan->id);

        if ($existingPayment) {
            return redirect()
                ->route('member.payments.show', $existingPayment)
                ->with('error', 'Anda sudah pernah mengambil pelatihan ini. Silakan lanjutkan ke menu pembayaran.');
        }

        if ($this->hasActiveOrCompletedTraining($user->id, $pelatihan->id)) {
            return redirect()
                ->route('member.pelatihan.index')
                ->with('error', 'Anda sudah pernah mengambil pelatihan ini.');
        }

        return view('member.pelatihan.konfirmasi', compact('pelatihan'));
    }

    public function take(Pelatihan $pelatihan)
    {
        $user = Auth::user();
        $existingPayment = $this->existingOpenPayment($user->id, $pelatihan->id);

        if ($existingPayment) {
            return redirect()
                ->route('member.payments.show', $existingPayment)
                ->with('error', 'Anda sudah pernah mengambil pelatihan ini. Silakan lanjutkan ke menu pembayaran.');
        }

        if ($this->hasActiveOrCompletedTraining($user->id, $pelatihan->id)) {
            return redirect()
                ->route('member.pelatihan.index')
                ->with('error', 'Anda sudah pernah mengambil pelatihan ini.');
        }

        try {
            $payment = DB::transaction(function () use ($user, $pelatihan) {
                $isFreeTraining = (float) $pelatihan->price <= 0;
                $payment = Payment::create([
                    'user_id' => $user->id,
                    'pelatihan_id' => $pelatihan->id,
                    'amount' => $pelatihan->price ?? 0,
                    'status' => $isFreeTraining ? 'paid' : 'pending',
                    'notes' => $isFreeTraining
                        ? 'Pelatihan gratis. Akses langsung aktif.'
                        : 'Pendaftaran berhasil dibuat. Silakan unggah bukti pembayaran.',
                    'approved_at' => $isFreeTraining ? now() : null,
                ]);

                if ($isFreeTraining) {
                    Sertifikat::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'pelatihan_id' => $pelatihan->id,
                        ],
                        [
                            'status' => 'in_progress',
                            'issue_date' => now()->toDateString(),
                        ]
                    );
                }

                return $payment;
            });

            if ($payment->isPaid()) {
                return redirect()
                    ->route('member.pelatihan.index')
                    ->with('success', 'Pelatihan gratis berhasil diambil dan sudah masuk ke Pelatihan Aktif.');
            }

            return redirect()
                ->route('member.payments.show', $payment)
                ->with('success', 'Pendaftaran pelatihan berhasil. Silakan lanjutkan ke menu pembayaran.');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal mendaftar pelatihan. Silakan coba lagi.');
        }
    }

    private function existingOpenPayment(int $userId, int $pelatihanId): ?Payment
    {
        return Payment::where('user_id', $userId)
            ->where('pelatihan_id', $pelatihanId)
            ->whereIn('status', ['pending', 'paid'])
            ->latest()
            ->first();
    }

    private function hasActiveOrCompletedTraining(int $userId, int $pelatihanId): bool
    {
        return Sertifikat::where('user_id', $userId)
            ->where('pelatihan_id', $pelatihanId)
            ->whereIn('status', ['in_progress', 'issued'])
            ->exists();
    }
}
