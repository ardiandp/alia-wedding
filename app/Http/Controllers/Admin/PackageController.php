<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageItem;
use App\Models\Venue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = Package::with('venue')->withCount('items')->orderBy('name')->paginate(15);

        return view('admin.packages.index', compact('packages'));
    }

    public function create(): View
    {
        $venues = Venue::where('is_active', true)->orderBy('name')->get();

        return view('admin.packages.create', compact('venues'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'venue_id' => ['nullable', 'exists:venues,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'price_type' => ['required', 'in:fixed,starting_from,custom'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'guest_capacity' => ['nullable', 'integer', 'min:1'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('packages', 'public');
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);

        Package::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Package berhasil dibuat.');
    }

    public function edit(Package $package): View
    {
        $package->load('items');
        $venues = Venue::where('is_active', true)->orderBy('name')->get();

        return view('admin.packages.edit', compact('package', 'venues'));
    }

    public function update(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'venue_id' => ['nullable', 'exists:venues,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'price_type' => ['required', 'in:fixed,starting_from,custom'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'guest_capacity' => ['nullable', 'integer', 'min:1'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('packages', 'public');
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);

        $package->update($validated);

        return back()->with('success', 'Package berhasil diperbarui.');
    }

    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package berhasil dihapus.');
    }

    public function storeItem(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        PackageItem::create([
            'package_id' => $package->id,
            'name' => $validated['name'],
            'sort_order' => $package->items()->count(),
        ]);

        return back()->with('success', 'Item berhasil ditambahkan.');
    }

    public function destroyItem(PackageItem $item): RedirectResponse
    {
        $item->delete();

        return back()->with('success', 'Item berhasil dihapus.');
    }
}
