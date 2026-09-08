<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function edit(): View
    {
        $about = About::firstOrCreate([], [
            'title' => 'Tentang Kami',
            'description' => '',
            'company_history' => '',
            'vision' => '',
            'missions' => [],
        ]);

        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request): RedirectResponse
    {
        $about = About::firstOrFail();

        $validated = $request->validate($this->rules());

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('abouts', 'public');
        }

        if ($request->has('missions') && is_array($request->missions)) {
            $validated['missions'] = array_filter($request->missions);
        }

        $about->update($validated);

        return back()->with('success', 'Halaman tentang berhasil diperbarui.');
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'company_history' => ['nullable', 'string'],
            'vision' => ['nullable', 'string', 'max:500'],
            'missions' => ['nullable', 'array'],
            'missions.*' => ['nullable', 'string', 'max:500'],
        ];
    }
}
