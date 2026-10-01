<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Models\VenueFacility;
use App\Models\VenueImage;
use App\Support\UrlRedirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VenueController extends Controller
{
    public function index(): View
    {
        $venues = Venue::withCount(['images', 'facilities'])
            ->orderBy('name')
            ->paginate(15);

        return view('admin.venues.index', compact('venues'));
    }

    public function create(): View
    {
        return view('admin.venues.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'size' => ['nullable', 'integer', 'min:1'],
            'type' => ['required', 'in:indoor,outdoor,indoor_outdoor'],
            'hero_image' => ['nullable', 'string', 'max:255'],
            'floor_plan' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'virtual_tour_url' => ['nullable', 'url', 'max:500'],
            'facility_note' => ['nullable', 'string'],
            'parking' => ['nullable', 'string'],
            'catering' => ['nullable', 'string'],
            'decoration' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:500'],
            'google_maps_embed' => ['nullable', 'url', 'max:1000'],
            'starting_price' => ['nullable', 'numeric', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['hero_image'] = blank($validated['hero_image'] ?? null) ? null : $validated['hero_image'];
        if ($request->hasFile('floor_plan')) {
            $validated['floor_plan'] = $request->file('floor_plan')->store('venues', 'public');
        }

        $validated['slug'] = UrlRedirect::uniqueSlug($validated['name'], 'venues');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);

        Venue::create($validated);

        return redirect()->route('admin.venues.index')->with('success', 'Venue berhasil dibuat.');
    }

    public function edit(Venue $venue): View
    {
        $venue->load(['images', 'facilities']);

        return view('admin.venues.edit', compact('venue'));
    }

    public function update(Request $request, Venue $venue): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'size' => ['nullable', 'integer', 'min:1'],
            'type' => ['required', 'in:indoor,outdoor,indoor_outdoor'],
            'hero_image' => ['nullable', 'string', 'max:255'],
            'floor_plan' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'virtual_tour_url' => ['nullable', 'url', 'max:500'],
            'facility_note' => ['nullable', 'string'],
            'parking' => ['nullable', 'string'],
            'catering' => ['nullable', 'string'],
            'decoration' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:500'],
            'google_maps_embed' => ['nullable', 'url', 'max:1000'],
            'starting_price' => ['nullable', 'numeric', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['hero_image'] = blank($validated['hero_image'] ?? null) ? null : $validated['hero_image'];
        if ($request->hasFile('floor_plan')) {
            $validated['floor_plan'] = $request->file('floor_plan')->store('venues', 'public');
        }

        $newSlug = UrlRedirect::uniqueSlug($validated['name'], 'venues', $venue->id);

        if ($newSlug !== $venue->slug) {
            UrlRedirect::recordFor('venues.show', 'venue', $venue->slug, $newSlug);
            $validated['slug'] = $newSlug;
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);

        $venue->update($validated);

        return back()->with('success', 'Venue berhasil diperbarui.');
    }

    public function destroy(Venue $venue): RedirectResponse
    {
        $venue->delete();

        return redirect()->route('admin.venues.index')->with('success', 'Venue berhasil dihapus.');
    }

    public function storeImage(Request $request, Venue $venue): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);

        VenueImage::create([
            'venue_id' => $venue->id,
            'image' => $request->file('image')->store('venues', 'public'),
            'caption' => $validated['caption'] ?? null,
            'sort_order' => $venue->images()->count(),
        ]);

        return back()->with('success', 'Foto venue berhasil ditambahkan.');
    }

    public function destroyImage(VenueImage $image): RedirectResponse
    {
        $image->delete();

        return back()->with('success', 'Foto venue berhasil dihapus.');
    }

    public function storeFacility(Request $request, Venue $venue): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        VenueFacility::create([
            'venue_id' => $venue->id,
            'name' => $validated['name'],
            'sort_order' => $venue->facilities()->count(),
        ]);

        return back()->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function destroyFacility(VenueFacility $facility): RedirectResponse
    {
        $facility->delete();

        return back()->with('success', 'Fasilitas berhasil dihapus.');
    }
}
