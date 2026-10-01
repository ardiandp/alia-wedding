<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageItem;
use App\Models\Venue;
use App\Support\UrlRedirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
            'image' => ['nullable', 'string', 'max:255'],
            'guest_capacity' => ['nullable', 'integer', 'min:1'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'string', 'max:500'],
            'items' => ['nullable', 'array'],
            'items.*' => ['nullable', 'string', 'max:255'],
        ]);

        $items = $validated['items'] ?? [];
        unset($validated['items']);

        $validated['image'] = blank($validated['image'] ?? null) ? null : $validated['image'];
        $validated['og_image'] = blank($validated['og_image'] ?? null) ? null : $validated['og_image'];
        $validated['canonical_url'] = blank($validated['canonical_url'] ?? null) ? null : $validated['canonical_url'];
        $validated['slug'] = UrlRedirect::uniqueSlug($validated['name'], 'packages');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);

        $package = DB::transaction(function () use ($validated, $items) {
            $package = Package::create($validated);

            $this->syncItems($package, $items);

            return $package;
        });

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
            'image' => ['nullable', 'string', 'max:255'],
            'guest_capacity' => ['nullable', 'integer', 'min:1'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'string', 'max:500'],
            'items' => ['nullable', 'array'],
            'items.*' => ['nullable', 'string', 'max:255'],
        ]);

        $items = $request->has('items') ? $validated['items'] : null;
        unset($validated['items']);

        $validated['image'] = blank($validated['image'] ?? null) ? null : $validated['image'];
        $validated['og_image'] = blank($validated['og_image'] ?? null) ? null : $validated['og_image'];
        $validated['canonical_url'] = blank($validated['canonical_url'] ?? null) ? null : $validated['canonical_url'];

        $newSlug = UrlRedirect::uniqueSlug($validated['name'], 'packages', $package->id);

        if ($newSlug !== $package->slug) {
            UrlRedirect::recordFor('packages.show', 'package', $package->slug, $newSlug);
            $validated['slug'] = $newSlug;
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);

        DB::transaction(function () use ($package, $validated, $items) {
            $package->update($validated);

            if ($items !== null) {
                $this->syncItems($package, $items);
            }
        });

        return back()->with('success', 'Package berhasil diperbarui.');
    }

    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package berhasil dihapus.');
    }

    /**
     * Replace the package feature list, keeping the submitted order.
     */
    private function syncItems(Package $package, mixed $items): void
    {
        $names = collect(Arr::wrap($items))
            ->filter(fn ($name) => is_string($name))
            ->map(fn (string $name) => trim($name))
            ->filter()
            ->unique()
            ->values();

        PackageItem::where('package_id', $package->id)->delete();

        if ($names->isEmpty()) {
            return;
        }

        $package->items()->createMany(
            $names->map(fn (string $name, int $index) => [
                'name' => $name,
                'sort_order' => $index,
            ])->all()
        );
    }
}
