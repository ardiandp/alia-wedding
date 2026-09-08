<?php

namespace App\Http\Controllers;

use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('items')
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('price')
            ->get();

        return view('package.index', compact('packages'));
    }

    public function show(Package $package)
    {
        $package->load(['items', 'venue']);

        return view('package.show', compact('package'));
    }
}
