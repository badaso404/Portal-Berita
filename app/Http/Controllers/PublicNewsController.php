<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\NewsService;

class PublicNewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index()
    {
        $featured = $this->newsService->listPublished([], 1)->first();
        
        $filters = [];
        if ($featured) {
            $filters['exclude_id'] = $featured->id;
        }
        
        $articles = $this->newsService->listPublished($filters, 10);
        $categories = \App\Models\Category::all();
        $trending = $this->newsService->listPublished([], 5); // Simulating trending with latest for now, or random if service supports

        return view('welcome', compact('featured', 'articles', 'categories', 'trending'));
    }

    public function show($slug)
    {
        $article = $this->newsService->getPublishedBySlug($slug);
        $relatedNews = $this->newsService->getRelatedArticles($article->category_id, $article->id, 3);
        
        return view('news.show', compact('article', 'relatedNews'));
    }

    public function search(Request $request)
    {
        $filters = $request->only(['title', 'category']);
        $articles = $this->newsService->listPublished($filters, 10);
        return view('news.index', compact('articles'));
    }
}
