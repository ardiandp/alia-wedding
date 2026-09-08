<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaLibrary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibraryController extends Controller
{
    public function index(): View
    {
        $media = Media::query()
            ->where('model_type', MediaLibrary::class)
            ->orderByDesc('id')
            ->paginate(24);

        return view('admin.media.index', compact('media'));
    }

    public function browser(Request $request): View
    {
        if (! $request->wantsJson() && ! $request->ajax()) {
            abort(404);
        }

        $media = Media::query()
            ->where('model_type', MediaLibrary::class)
            ->orderByDesc('id')
            ->limit(200)
            ->get();

        return view('admin.media.partials.browser', compact('media'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'image', 'mimes:jpeg,png,webp', 'max:10240'],
        ]);

        $media = media_library()
            ->addMediaFromRequest('file')
            ->toMediaCollection('uploads', 'public');

        return response()->json([
            'ok' => true,
            'id' => $media->id,
            'path' => media_relative_path($media),
            'url' => image_url(media_relative_path($media)),
        ]);
    }

    public function destroy(Media $media): RedirectResponse
    {
        $media->delete();

        return redirect()->route('admin.media.index')->with('success', 'Media berhasil dihapus.');
    }
}
