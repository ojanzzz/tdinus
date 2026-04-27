<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Support\ImageOptimizer;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        return view('admin.sliders.index', [
            'sliders' => Slider::orderBy('sort_order')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['nullable','string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:3072'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = ImageOptimizer::storeUploadedImage($request->file('image'));
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Slider::create($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:3072'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $this->deleteImageIfExists($slider->image_path);
            $data['image_path'] = ImageOptimizer::storeUploadedImage($request->file('image'));
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $slider->update($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil diperbarui.');
    }

    public function destroy(Slider $slider)
    {
        $this->deleteImageIfExists($slider->image_path);
        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil dihapus.');
    }

    private function deleteImageIfExists(?string $path): void
    {
        ImageOptimizer::deletePublicImage($path);
    }
}
