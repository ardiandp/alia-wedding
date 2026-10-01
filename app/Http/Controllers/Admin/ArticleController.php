<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Support\UrlRedirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::orderByRaw('published_at IS NULL')->orderByDesc('published_at')->orderByDesc('created_at')->paginate(15);

        return view('admin.articles.index', compact('articles'));
    }

    public function create(): View
    {
        return view('admin.articles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $validated['image'] = blank($validated['image'] ?? null) ? null : $validated['image'];
        $validated['og_image'] = blank($validated['og_image'] ?? null) ? null : $validated['og_image'];
        $validated['canonical_url'] = blank($validated['canonical_url'] ?? null) ? null : $validated['canonical_url'];
        $validated['slug'] = UrlRedirect::uniqueSlug($validated['title'], 'articles');
        $validated['published_at'] = $this->resolvePublishedAt($validated);

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $validated['image'] = blank($validated['image'] ?? null) ? null : $validated['image'];
        $validated['og_image'] = blank($validated['og_image'] ?? null) ? null : $validated['og_image'];
        $validated['canonical_url'] = blank($validated['canonical_url'] ?? null) ? null : $validated['canonical_url'];

        $newSlug = UrlRedirect::uniqueSlug($validated['title'], 'articles', $article->id);

        if ($newSlug !== $article->slug) {
            UrlRedirect::recordFor('articles.show', 'article', $article->slug, $newSlug);
            $validated['slug'] = $newSlug;
        }

        $validated['published_at'] = $this->resolvePublishedAt($validated, $article);

        $article->update($validated);

        return back()->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }

    private function resolvePublishedAt(array $validated, ?Article $article = null): ?string
    {
        if (! blank($validated['published_at'] ?? null)) {
            return $validated['published_at'];
        }

        if (($validated['status'] ?? null) === 'published') {
            return now();
        }

        return $article?->published_at;
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'string', 'max:500'],
        ];
    }
}
