<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $articles = Article::with('user')->latest()->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable',
            'published' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->has('published') && $request->published) {
            $validated['published_at'] = now();
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable',
            'published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->has('published') && $request->published && !$article->published) {
            $validated['published_at'] = now();
        } elseif (!$request->has('published') || !$request->published) {
            $validated['published_at'] = null;
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }
}
