<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Support\ImageOptimizer;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view('admin.services.index', [
            'services' => Service::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'url_layanan' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = ImageOptimizer::storeUploadedImage($request->file('image'));
        }

        $data['is_active'] = $request->boolean('is_active');

        Service::create($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'url_layanan' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $this->deleteImageIfExists($service->image_path);
            $data['image_path'] = ImageOptimizer::storeUploadedImage($request->file('image'));
        }

        $data['is_active'] = $request->boolean('is_active');

        $service->update($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $this->deleteImageIfExists($service->image_path);
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }

    private function deleteImageIfExists(?string $path): void
    {
        ImageOptimizer::deletePublicImage($path);
    }
}
