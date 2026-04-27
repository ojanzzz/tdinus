<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Support\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        return view('admin.news.index', [
            'news' => News::latest()->get(),
        ]);
    }

    public function create()
    {
        $categories = News::distinct('category')->whereNotNull('category')->where('category', '!=', '')->pluck('category')->sort();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['body'] = $this->processTinyMCEBody($data['body'], true); // process images

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title']);

        if ($request->hasFile('image')) {
            $data['image_path'] = ImageOptimizer::storeUploadedImage($request->file('image'));
        }

        $data['is_active'] = $request->boolean('is_active');

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        $categories = News::distinct('category')->whereNotNull('category')->where('category', '!=', '')->pluck('category')->sort();
        $news->body = $this->processTinyMCEBody($news->body, false); // restore images for edit
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['body'] = $this->processTinyMCEBody($data['body'], true); // process images

        $desiredSlug = $data['slug'] ?: $data['title'];
        if ($desiredSlug && $desiredSlug !== $news->slug) {
            $data['slug'] = $this->uniqueSlug($desiredSlug, $news->id);
        } else {
            unset($data['slug']);
        }

        if ($request->hasFile('image')) {
            $this->deleteImageIfExists($news->image_path);
            $data['image_path'] = ImageOptimizer::storeUploadedImage($request->file('image'));
        }

        $data['is_active'] = $request->boolean('is_active');

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        $this->deleteNewsImages($news->body); // delete embedded images
        $this->deleteImageIfExists($news->image_path);
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    private function processTinyMCEBody($body, $save = true)
    {
        if (!$body) return $body;

        if ($save) {
            // Convert base64 images to uploaded files
            $body = preg_replace_callback('/<img src="data:image\/([a-z]+);base64,([^"]+)"/i', function ($matches) {
                $ext = $matches[1];
                $data = base64_decode($matches[2]);
                $filename = Str::uuid() . '.' . $ext;
                $path = 'uploads/news/' . $filename;
                Storage::disk('public')->put($path, $data);
                return '<img src="' . Storage::url($path) . '"';
            }, $body);
        } else {
            // For edit, no change needed (TinyMCE handles URLs)
        }

        return $body;
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value ?: 'news');
        $slug = $base ?: 'news';
        $counter = 1;

        while (News::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function deleteImageIfExists(?string $path): void
    {
        ImageOptimizer::deletePublicImage($path);
    }

    private function deleteNewsImages($body)
    {
        if (!$body) return;

        preg_match_all('/src=\\"\/storage\/uploads\/news\/([a-f0-9\\-]+\.(jpg|jpeg|png|gif|webp))"/', $body, $matches);
        foreach ($matches[1] ?? [] as $filename) {
            $path = public_path('storage/uploads/news/' . $filename);
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }
}
