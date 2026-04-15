<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MemberSettingController;
use App\Http\Controllers\Admin\MemberUserController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\PelatihanController;
use App\Http\Controllers\Admin\SertifikatController;
use App\Http\Controllers\Member\PelatihanController as MemberPelatihanController;
use App\Http\Controllers\Member\SertifikatController as MemberSertifikatController;
use App\Http\Controllers\Member\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home']);
Route::view('/tentang', 'tentang');
Route::get('/layanan-kami', [PublicController::class, 'services']);
Route::get('/berita', [PublicController::class, 'news']);
Route::get('/berita/{slug}', [PublicController::class, 'newsDetail']);
Route::get('/pelatihan', [PublicController::class, 'pelatihan']);
Route::view('/kontak-kami', 'kontak-kami');

Route::get('/login/{role}', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login/{role}', [AuthController::class, 'login'])->name('login.perform');
Route::post('/register/member', [AuthController::class, 'register'])->name('register.member');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('sliders', SliderController::class)->except(['show']);
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('news', NewsController::class)->except(['show']);
    Route::resource('pelatihan', \App\Http\Controllers\Admin\PelatihanController::class)->except(['show']);
    Route::patch('sertifikat/{sertifikat}/complete', [\App\Http\Controllers\Admin\SertifikatController::class, 'complete'])->name('sertifikat.complete');
    Route::resource('sertifikat', \App\Http\Controllers\Admin\SertifikatController::class);
    Route::resource('admin-settings', AdminSettingController::class)->except(['show']);
    Route::resource('member-settings', MemberSettingController::class)->except(['show']);
    Route::resource('members', MemberUserController::class)->except(['show'])->parameters(['members' => 'member']);
    Route::patch('members/sertifikat/{sertifikat}/confirm', [MemberUserController::class, 'confirmSertifikat'])->name('admin.members.sertifikat.confirm');
    Route::patch('members/sertifikat/{sertifikat}/reject', [MemberUserController::class, 'rejectSertifikat'])->name('admin.members.sertifikat.reject');
    Route::patch('members/sertifikat/{sertifikat}/update-status', [MemberUserController::class, 'updateSertifikatStatus'])->name('admin.members.sertifikat.update-status');
});

Route::middleware(['auth', 'role:member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/', [MemberDashboardController::class, 'index'])->name('dashboard');
    Route::resource('pelatihan', MemberPelatihanController::class)->only(['index']);
    Route::post('pelatihan/{pelatihan}/take', [MemberPelatihanController::class, 'take'])->name('pelatihan.take');
    Route::resource('sertifikat', MemberSertifikatController::class)->only(['index']);
    Route::resource('profile', ProfileController::class)->only(['index', 'update']);
});

