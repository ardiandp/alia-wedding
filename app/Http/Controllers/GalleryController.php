<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Gallery::CATEGORIES;

        $category = $request->filled('category') && in_array($request->category, $categories)
            ? $request->category
            : null;

        $query = Gallery::where('is_active', true)->orderBy('sort_order');

        if ($category) {
            $query->where('category', $category);
        }

        $images = $query->paginate(16)->withQueryString();

        return view('gallery.index', compact('images', 'categories', 'category'));
    }
}
