<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $activeCategory = null;

        if ($request->filled('category')) {
            $activeCategory = Category::where('slug', $request->query('category'))->first();
        }

        $articles = Article::published()
            ->with('categories')
            ->when($activeCategory, fn ($query) => $query->whereHas(
                'categories',
                fn ($q) => $q->where('categories.id', $activeCategory->id)
            ))
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9)
            ->withQueryString();

        $categories = Category::withCount('articles')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('article.index', compact('articles', 'categories', 'activeCategory'));
    }

    public function category(Category $category)
    {
        $articles = $category->articles()
            ->published()
            ->with('categories')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9);

        $categories = Category::withCount('articles')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('article.index', [
            'articles' => $articles,
            'categories' => $categories,
            'activeCategory' => $category,
        ]);
    }

    public function show(Article $article)
    {
        abort_if(
            $article->status !== 'published' || ($article->published_at && $article->published_at->isFuture()),
            404
        );

        $article->load('categories');

        return view('article.show', compact('article'));
    }
}
