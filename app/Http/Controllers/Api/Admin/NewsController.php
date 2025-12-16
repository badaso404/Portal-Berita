<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Http\Request;

use App\Services\ArticleService;

class NewsController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    // POST /api/admin/news
    public function store(StoreArticleRequest $request)
    {
        $article = $this->articleService->create(
            $request->validated(),
            $request->file('image'),
            $request->user()->id
        );

        return new ArticleResource($article);
    }

    // PUT /api/admin/news/{id}
    public function update(UpdateArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);
        
        $article = $this->articleService->update(
            $article,
            $request->validated(),
            $request->file('image')
        );

        return new ArticleResource($article);
    }

    // DELETE /api/admin/news/{id}
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $this->articleService->delete($article);

        return response()->json(['message' => 'Article deleted successfully']);
    }
}
