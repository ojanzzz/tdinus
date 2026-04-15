<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Service;
use App\Models\Pelatihan;
use App\Models\Slider;

class PublicController extends Controller
{
    public function home()
    {
        return view('home', [
            'sliders' => Slider::where('is_active', true)->orderBy('sort_order')->get(),
            'services' => Service::where('is_active', true)->latest()->take(4)->get(),
'newsItems' => News::where('is_active', true)->latest()->take(3)->get(),
            'pelatihans' => Pelatihan::where('status', 'active')->latest()->take(4)->get(),
        ]);
    }

    public function services()
    {
        return view('layanan-kami', [
            'services' => Service::where('is_active', true)->latest()->get(),
        ]);
    }

    public function news()
    {
        return view('berita', [
            'newsItems' => News::where('is_active', true)->latest()->paginate(9),
        ]);
    }

    public function newsDetail(string $slug)
    {
        $news = News::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('berita-detail', [
            'news' => $news,
        ]);
    }

    public function pelatihan()
    {
        return view('pelatihan', [
            'pelatihans' => Pelatihan::where('status', 'active')->latest()->paginate(9),
        ]);
    }
}
