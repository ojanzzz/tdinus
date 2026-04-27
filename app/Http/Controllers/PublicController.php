<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Pelatihan;
use App\Models\Service;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Kudashevs\ShareButtons\Facades\ShareButtonsFacade as ShareButtons;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class PublicController extends Controller
{
    public function sitemap(Request $request)
    {
        $sitemap = Sitemap::create();

        // Static pages
        $sitemap->add(Url::create('/')->setLastModificationDate(Carbon::now()))
                ->add(Url::create('/tentang'))
                ->add(Url::create('/layanan-kami'))
                ->add(Url::create('/berita'))
                ->add(Url::create('/pelatihan'))
                ->add(Url::create('/kontak-kami'));

// Services (list page)
        $sitemap->add(Url::create('/layanan-kami')->setLastModificationDate(Carbon::now()));
        // Per service if have detail page (add if needed)
        // $sitemap->add(Service::where('is_active', true)->get()->map(function ($service) {
        //     return Url::create("/layanan/{$service->slug}")...
        // }));

        // News
        $sitemap->add(News::where('is_active', true)->get()->map(function ($news) {
            $url = $news->slug ? "/berita/{$news->slug}" : "/berita/{$news->id}";
            return Url::create($url)
                ->setLastModificationDate($news->updated_at ?? Carbon::now());
        }));

        // Pelatihan
        $sitemap->add(Pelatihan::where('status', 'active')->get()->map(function ($pelatihan) {
            return Url::create('/pelatihan/' . $pelatihan->id) // adjust if slug
                ->setLastModificationDate($pelatihan->updated_at ?? Carbon::now());
        }));

        // Sliders/home featured if needed
        // $sitemap->add(Slider::where('is_active', true)->get()->map(...));

        return $sitemap->toResponse($request);
    }

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

        $shareButtons = new HtmlString(
            ShareButtons::currentPage($news->title, [
                'block_prefix' => '<div class="share-buttons" id="social-buttons">',
                'block_suffix' => '</div>',
            ])
                ->facebook([
                    'class' => 'share-btn share-btn--facebook',
                    'title' => 'Bagikan ke Facebook',
                    'rel' => 'noopener noreferrer nofollow',
                ])
                ->twitter([
                    'class' => 'share-btn share-btn--x',
                    'title' => 'Bagikan ke X',
                    'rel' => 'noopener noreferrer nofollow',
                ])
                ->whatsapp([
                    'class' => 'share-btn share-btn--whatsapp',
                    'title' => 'Bagikan ke WhatsApp',
                    'rel' => 'noopener noreferrer nofollow',
                ])
                ->copylink([
                    'class' => 'share-btn share-btn--copy',
                    'title' => 'Salin tautan berita',
                    'rel' => 'noopener noreferrer nofollow',
                ])
                ->render()
        );

        return view('berita-detail', compact('news', 'categories', 'shareButtons'));
    }

    public function pelatihan()
    {
        return view('pelatihan', [
            'pelatihans' => Pelatihan::where('status', 'active')->latest()->paginate(9),
        ]);
    }

    public function pelatihanDetail($slug)
    {
        $pelatihan = Pelatihan::where('status', 'active')
            ->where(function ($query) use ($slug) {
                $query->where('slug', $slug)
                    ->orWhere('id', $slug);
            })
            ->firstOrFail();

        $pelatihans = Pelatihan::where('status', 'active')->latest()->paginate(9);
        $memberPayment = null;

        if (auth()->check()) {
            $user = auth()->user();
            $hasSertifikat = $user->sertifikats()->where('pelatihan_id', $pelatihan->id)->exists();
            $memberPayment = $user->payments()
                ->where('pelatihan_id', $pelatihan->id)
                ->latest()
                ->first();
            $hasPayment = $memberPayment && $memberPayment->status !== 'rejected';
            $pelatihan->is_taken = $hasSertifikat || $hasPayment;
        } else {
            $pelatihan->is_taken = false;
        }

        return view('pelatihan.detail', compact('pelatihan', 'pelatihans', 'memberPayment'));
    }
}
