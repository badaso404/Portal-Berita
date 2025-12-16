<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\Category;
use App\Services\ArticleService;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class NewsController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $articles = Article::with('category', 'user')->latest()->paginate(10);
        return view('admin.news.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(StoreArticleRequest $request)
    {
        $this->articleService->create(
            $request->validated(),
            $request->file('image'),
            $request->user()->id
        );

        return redirect()->route('admin.news.index')->with('success', 'Article created successfully.');
    }

    public function edit(Article $news)
    {
        $categories = Category::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(UpdateArticleRequest $request, Article $news)
    {
        $this->articleService->update(
            $news,
            $request->validated(),
            $request->file('image')
        );

        return redirect()->route('admin.news.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $news)
    {
        $this->articleService->delete($news);
        return redirect()->route('admin.news.index')->with('success', 'Article deleted successfully.');
    }
}
