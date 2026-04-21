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
            'sertifikatCount' => $user->sertifikats()->count(),
            'completedPelatihan' => $user->sertifikats()->with('pelatihan')->latest()->take(5)->get(),
        ]);
    }
}
