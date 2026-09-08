<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::with('venue')->orderBy('start_date')->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        $venues = Venue::where('is_active', true)->orderBy('name')->get();

        return view('admin.events.create', compact('venues'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }
        $validated['slug'] = Str::slug($validated['title']);

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil dibuat.');
    }

    public function edit(Event $event): View
    {
        $venues = Venue::where('is_active', true)->orderBy('name')->get();

        return view('admin.events.edit', compact('event', 'venues'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }
        $validated['slug'] = Str::slug($validated['title']);

        $event->update($validated);

        return back()->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'venue_id' => ['nullable', 'exists:venues,id'],
            'title' => ['required', 'string', 'max:255'],
            'event_type' => ['required', 'in:wedding,open_house,expo,venue_tour,food_testing,promotion'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'status' => ['required', 'in:draft,published,completed,cancelled'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
