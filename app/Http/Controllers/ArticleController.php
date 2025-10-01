<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('published', true)
            ->latest('published_at')
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        return view('articles.show', compact('article'));
    }
}
