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
        $query = News::where('is_active', true)->latest();
        
        if (request('category')) {
            $query->where('category', request('category'));
        }
        
        $categories = News::where('is_active', true)
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->sort();
        
        $newsItems = $query->paginate(9);
        
        $newsItems->appends(request()->query());
        
        return view('berita', compact('newsItems', 'categories'));
    }

    public function newsDetail(string $slug)
    {
        $news = News::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $categories = News::where('is_active', true)
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->sort();

        return view('berita-detail', compact('news', 'categories'));
    }

    public function pelatihan()
    {
        return view('pelatihan', [
            'pelatihans' => Pelatihan::where('status', 'active')->latest()->paginate(9),
        ]);
    }
}
