<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomepageController extends Controller
{
    private const SECTIONS = [
        'hero' => [
            'heading',
            'description',
            'image',
            'cta_primary_text',
            'cta_primary_url',
            'cta_secondary_text',
            'cta_secondary_url',
        ],
        'intro' => [
            'title',
            'description',
            'image',
        ],
        'stats' => [
            'happy_couples',
            'happy_couples_label',
            'years_experience',
            'years_experience_label',
            'events_year',
            'events_year_label',
            'professional_vendors',
            'professional_vendors_label',
        ],
        'promotion' => [
            'title',
            'description',
            'cta_text',
            'cta_url',
        ],
        'contact_cta' => [
            'title',
            'cta_text',
            'cta_url',
        ],
    ];

    public function edit(): View
    {
        $sections = [];

        foreach (self::SECTIONS as $section => $keys) {
            $content = HomepageContent::section($section);
            $sections[$section] = [];

            foreach ($keys as $key) {
                $sections[$section][$key] = $content->get($key, '');
            }
        }

        return view('admin.homepage.edit', compact('sections'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sections' => ['required', 'array'],
            'hero_image' => ['nullable', 'string', 'max:255'],
            'intro_image' => ['nullable', 'string', 'max:255'],
        ]);

        foreach (self::SECTIONS as $section => $keys) {
            foreach ($keys as $key) {
                $value = $request->input("sections.{$section}.{$key}", '');

                HomepageContent::updateOrCreate(
                    ['section' => $section, 'key' => $key],
                    ['value' => $value]
                );
            }
        }

        foreach (['hero' => 'hero_image', 'intro' => 'intro_image'] as $section => $field) {
            $value = $request->input($field);

            HomepageContent::updateOrCreate(
                ['section' => $section, 'key' => 'image'],
                ['value' => blank($value) ? '' : $value]
            );
        }

        return back()->with('success', 'Konten homepage berhasil diperbarui.');
    }
}
