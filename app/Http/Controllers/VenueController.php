<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $query = Venue::with(['images', 'facilities'])
            ->where('is_active', true);

        if ($request->filled('type') && in_array($request->type, ['indoor', 'outdoor', 'indoor_outdoor'])) {
            $query->where('type', $request->type);
        }

        if ($request->filled('capacity')) {
            $query->where('capacity', '>=', (int) $request->capacity);
        }

        $venues = $query->orderByDesc('is_featured')->orderBy('name')->paginate(9)->withQueryString();

        return view('venue.index', compact('venues'));
    }

    public function show(Venue $venue)
    {
        $venue->load(['images', 'facilities', 'packages' => fn ($q) => $q->where('is_active', true)]);

        return view('venue.show', compact('venue'));
    }
}
