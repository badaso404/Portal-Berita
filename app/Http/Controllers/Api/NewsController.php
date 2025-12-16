<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

use App\Services\NewsService;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    // GET /api/news
    public function index()
    {
        $articles = $this->newsService->listPublished();
        return ArticleResource::collection($articles);
    }

    // GET /api/news/{id}
    public function show($id)
    {
        $article = $this->newsService->getPublishedById($id);
        return new ArticleResource($article);
    }

    // GET /api/news/category/{slug}
    public function category($slug)
    {
        $articles = $this->newsService->listPublished(['category' => $slug]);
        return ArticleResource::collection($articles);
    }

    // GET /api/news/search
    public function search(Request $request)
    {
        $filters = $request->only(['title', 'date', 'category']);
        $articles = $this->newsService->listPublished($filters);
        return ArticleResource::collection($articles);
    }
}
