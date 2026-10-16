<?php

namespace App\Http\Controllers;

use App\Models\ClickEvent;
use App\Support\Tracking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Records outbound CTA clicks (WhatsApp, phone, email, contact form links).
 */
class TrackClickController extends Controller
{
    private const ALLOWED_LABELS = ['whatsapp', 'phone', 'email', 'contact', 'cta'];

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:60'],
            'path' => ['nullable', 'string', 'max:255'],
            'target' => ['nullable', 'string', 'max:255'],
        ]);

        if (! in_array($validated['label'], self::ALLOWED_LABELS, true)) {
            $validated['label'] = 'cta';
        }

        ClickEvent::create([
            'label' => $validated['label'],
            'path' => Str::limit($validated['path'] ?? '/', 255, ''),
            'target' => Str::limit($validated['target'] ?? '', 255, ''),
            'visitor_hash' => Tracking::visitorHash($request),
            'ip_hash' => Tracking::ipHash($request),
            'created_at' => now(),
        ]);

        return response()->json(['ok' => true], 202);
    }
}
