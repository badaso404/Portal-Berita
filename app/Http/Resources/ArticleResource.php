<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content, // Or substr for list? Better to be explicit or use another resource for list if needed. Assuming full detail for now or client handles.
            'image' => $this->image ? url('storage/' . $this->image) : null,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'author' => $this->user->name, // Simple author name
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
