<?php

namespace App\Http\Controllers;

use App\Events\ArticleWasCreated;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Support\Facades\Http;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    public function index()
    {
        $response = Http::get('https://quotes.rest/qod?language=en');
        if(isset($response->body()->contents)){
            $quote = json_decode($response->body())->contents->quotes[0]->quote;
            $author = json_decode($response->body())->contents->quotes[0]->author;
        } else {
            $quote = null;
            $author = null;
        }

        return view('articles.index', [
            'articles' => (new Article)->all(),
            'quote' => $quote,
            'author' => $author
        ]);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(ArticleRequest $request)
    {
        $article = (new Article)->fill($request->all());
        $article->user()->associate(auth()->user());
        $article->save();

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
