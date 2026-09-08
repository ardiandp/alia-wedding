<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::orderBy('sort_order')->orderBy('id', 'desc')->paginate(20);

        return view('admin.galleries.index', compact('galleries'));
    }

    public function create(): View
    {
        $categories = Gallery::CATEGORIES;

        return view('admin.galleries.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $validated['image'] = blank($validated['image'] ?? null) ? null : $validated['image'];
        $validated['is_active'] = $request->boolean('is_active');

        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil dibuat.');
    }

    public function edit(Gallery $gallery): View
    {
        $categories = Gallery::CATEGORIES;

        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $validated['image'] = blank($validated['image'] ?? null) ? null : $validated['image'];
        $validated['is_active'] = $request->boolean('is_active');

        $gallery->update($validated);

        return back()->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:'.implode(',', Gallery::CATEGORIES)],
            'image' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
