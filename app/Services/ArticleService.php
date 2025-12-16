<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleService
{
    public function create(array $data, ?UploadedFile $image = null, int $userId): Article
    {
        $data['slug'] = $this->generateSlug($data['title']);
        $data['user_id'] = $userId;

        if ($image) {
            $data['image'] = $image->store('news_images', 'public');
        }

        return Article::create($data);
    }

    public function update(Article $article, array $data, ?UploadedFile $image = null): Article
    {
        if (isset($data['title'])) {
            $data['slug'] = $this->generateSlug($data['title']);
        }

        if ($image) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $image->store('news_images', 'public');
        }

        $article->update($data);

        return $article;
    }

    public function delete(Article $article): void
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();
    }

    protected function generateSlug(string $title): string
    {
        return Str::slug($title) . '-' . Str::random(5);
    }
}
