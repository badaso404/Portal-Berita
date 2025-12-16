<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class NewsService
{
    /**
     * Get published news with optional filters.
     */
    public function listPublished(array $filters = [], int $limit = 10): LengthAwarePaginator
    {
        $query = Article::with(['category', 'user'])
            ->where('status', 'published');

        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (!empty($filters['date'])) {
            $query->whereDate('published_at', $filters['date']);
        }

        if (!empty($filters['category'])) {
            $query->whereHas('category', function (Builder $q) use ($filters) {
                $q->where('slug', $filters['category']);
            });
        }

        if (!empty($filters['exclude_id'])) {
            $query->where('id', '!=', $filters['exclude_id']);
        }

        return $query->latest('published_at')->paginate($limit);
    }

    /**
     * Get a single published article by slug (or ID).
     */
    public function getPublishedBySlug(string $slug): Article
    {
        // Supporting search by ID as well if needed, but requirements say slug usually for SEO
        // API implementation used ID, Frontend often uses Slug. Let's support ID fallback or just Slug.
        // For consistency with API that currently uses ID, I'll add a separate method or logic. 
        // But requirement "GET /api/news/{id}" implies ID. 
        // Public web usually prefers slug.
        
        return Article::with(['category', 'user'])
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function getPublishedById(int $id): Article
    {
        return Article::with(['category', 'user'])
            ->where('status', 'published')
            ->findOrFail($id);
    }

    /**
     * Get related articles based on category.
     */
    public function getRelatedArticles(int $categoryId, int $excludeId, int $limit = 3)
    {
        return Article::with(['category', 'user'])
            ->where('status', 'published')
            ->where('category_id', $categoryId)
            ->where('id', '!=', $excludeId)
            ->latest('published_at')
            ->take($limit)
            ->get();
    }
}
