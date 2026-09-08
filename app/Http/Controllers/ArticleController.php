<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::published()
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9)
            ->withQueryString();

        return view('article.index', compact('articles'));
    }

    public function show(Article $article)
    {
        abort_if(
            $article->status !== 'published' || ($article->published_at && $article->published_at->isFuture()),
            404
        );

        return view('article.show', compact('article'));
    }
}
