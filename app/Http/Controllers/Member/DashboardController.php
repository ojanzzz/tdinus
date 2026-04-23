<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('member.dashboard', [
            'sertifikatCount' => $user->sertifikats()->where('status', 'issued')->count(),
            'activePelatihanCount' => $user->sertifikats()->where('status', 'in_progress')->count(),
            'pendingSertifikatCount' => $user->payments()->where('status', 'pending')->count(),
            'recentSertifikats' => $user->sertifikats()
                ->with('pelatihan')
                ->where('status', 'issued')
                ->latest('issue_date')
                ->take(3)
                ->get(),
        ]);
    }
}
