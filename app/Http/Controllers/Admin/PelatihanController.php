<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Support\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PelatihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pelatihan.index', [
            'pelatihans' => Pelatihan::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.pelatihan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'duration' => ['nullable', 'string', 'max:100'],
            'price' => ['nullable', 'numeric'],
        ]);

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title']);

        if ($request->hasFile('image')) {
            $data['image_path'] = ImageOptimizer::storeUploadedImage($request->file('image'));
        }

        $data['status'] = $request->boolean('status', true) ? 'active' : 'inactive';

        Pelatihan::create($data);

        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Pelatihan berhasil ditambahkan.');
    }

    public function show(Pelatihan $pelatihan)
    {
        //
    }

    public function edit(Pelatihan $pelatihan)
    {
        return view('admin.pelatihan.edit', compact('pelatihan'));
    }

    public function update(Request $request, Pelatihan $pelatihan)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'duration' => ['nullable', 'string', 'max:100'],
            'price' => ['nullable', 'numeric'],
        ]);

        $desiredSlug = $data['slug'] ?? $data['title'];
        if ($desiredSlug && $desiredSlug !== $pelatihan->slug) {
            $data['slug'] = $this->uniqueSlug($desiredSlug, $pelatihan->id);
        } else {
            unset($data['slug']);
        }

        if ($request->hasFile('image')) {
            $this->deleteImageIfExists($pelatihan->image_path);
            $data['image_path'] = ImageOptimizer::storeUploadedImage($request->file('image'));
        }

        $data['status'] = $request->boolean('status', true) ? 'active' : 'inactive';

        $pelatihan->update($data);

        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Pelatihan berhasil diperbarui.');
    }

    public function destroy(Pelatihan $pelatihan)
    {
        $this->deleteImageIfExists($pelatihan->image_path);
        $pelatihan->delete();

        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Pelatihan berhasil dihapus.');
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value ?: 'pelatihan');
        $slug = $base ?: 'pelatihan';
        $counter = 1;

        while (Pelatihan::where('slug', $slug)
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
}
