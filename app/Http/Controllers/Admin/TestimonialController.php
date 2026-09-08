<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Venue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::with('venue')->orderBy('id', 'desc')->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        $venues = Venue::where('is_active', true)->orderBy('name')->get();

        return view('admin.testimonials.create', compact('venues'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $validated['photo'] = blank($validated['photo'] ?? null) ? null : $validated['photo'];
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dibuat.');
    }

    public function edit(Testimonial $testimonial): View
    {
        $venues = Venue::where('is_active', true)->orderBy('name')->get();

        return view('admin.testimonials.edit', compact('testimonial', 'venues'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $validated['photo'] = blank($validated['photo'] ?? null) ? null : $validated['photo'];
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        $testimonial->update($validated);

        return back()->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'partner_name' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'testimonial' => ['required', 'string'],
            'wedding_date' => ['nullable', 'date'],
            'venue_id' => ['nullable', 'exists:venues,id'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
