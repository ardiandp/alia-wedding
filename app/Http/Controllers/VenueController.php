<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $venues = Venue::where('is_active', true)
            ->withCount(['images', 'facilities', 'packages'])
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->paginate(12);

        return view('venue.index', compact('venues'));
    }

    public function show(Venue $venue)
    {
        abort_if(! $venue->is_active, 404);

        $venue->load([
            'images' => fn ($q) => $q->orderBy('sort_order'),
            'facilities' => fn ($q) => $q->orderBy('sort_order'),
            'packages' => fn ($q) => $q->where('is_active', true)->orderBy('name'),
        ]);

        return view('venue.show', compact('venue'));
    }
}
