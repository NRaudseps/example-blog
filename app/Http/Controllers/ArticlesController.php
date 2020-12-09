<?php

namespace App\Http\Controllers;

use App\Events\ArticleWasCreated;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    public function index()
    {
        $articles  = Article::all()->sortByDesc('created_at');

        return view('articles.index', [
            'articles' => $articles
        ]);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(ArticleRequest $request)
    {
        $article = auth()->user()->articles()->create($request->all());

        event(new ArticleWasCreated($article));

        return redirect()->route('articles.index');
    }

    public function show(Article $article)
    {
        return view('articles.show', [
            'article' => $article
        ]);
    }

    public function edit(Article $article)
    {
        return view('articles.edit', [
            'article' => $article
        ]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->update($request->all());

        return redirect()->route('articles.edit', $article);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index');
    }

    public function lazy()
    {
        for($i = 0; $i < 100; $i++){
            Article::factory()->create(['user_id' => auth()->user()->id]);
        }

        return redirect()->route('articles.index');
    }
}
