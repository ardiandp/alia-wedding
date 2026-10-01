<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $packages = Package::where('is_active', true)
            ->with('venue')
            ->orderByDesc('is_featured')
            ->orderBy('price')
            ->paginate(12);

        return view('package.index', compact('packages'));
    }

    public function show(Package $package)
    {
        abort_if(! $package->is_active, 404);

        $package->load(['venue', 'items' => fn ($q) => $q->orderBy('sort_order')]);

        return view('package.show', compact('package'));
    }
}
