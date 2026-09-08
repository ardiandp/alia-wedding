<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $teams = Team::orderBy('sort_order')->orderBy('id', 'desc')->paginate(15);

        return view('admin.teams.index', compact('teams'));
    }

    public function create(): View
    {
        return view('admin.teams.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $validated['photo'] = blank($validated['photo'] ?? null) ? null : $validated['photo'];
        $validated['is_active'] = $request->boolean('is_active');

        Team::create($validated);

        return redirect()->route('admin.teams.index')->with('success', 'Tim berhasil dibuat.');
    }

    public function edit(Team $team): View
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $validated['photo'] = blank($validated['photo'] ?? null) ? null : $validated['photo'];
        $validated['is_active'] = $request->boolean('is_active');

        $team->update($validated);

        return back()->with('success', 'Tim berhasil diperbarui.');
    }

    public function destroy(Team $team): RedirectResponse
    {
        $team->delete();

        return redirect()->route('admin.teams.index')->with('success', 'Tim berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
