<?php

namespace App\Http\Resources;

use App\Support\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'location' => $this->location,
            'price' => $this->price,
            'priceLabel' => $this->price_label,
            'area' => $this->area,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'status' => $this->status,
            'image' => Media::url($this->image),
            'gallery' => Media::urls($this->gallery),
            'amenities' => $this->amenities,
        ];
    }
}
