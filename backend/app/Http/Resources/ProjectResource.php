<?php

namespace App\Http\Resources;

use App\Support\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'location' => $this->location,
            'category' => $this->category,
            'year' => $this->year,
            'description' => $this->description,
            'image' => Media::url($this->image),
            'gallery' => Media::urls($this->gallery),
            'stats' => $this->stats,
        ];
    }
}
