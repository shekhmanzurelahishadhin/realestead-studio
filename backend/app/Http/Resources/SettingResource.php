<?php

namespace App\Http\Resources;

use App\Support\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'siteName' => $this->site_name,
            'tagline' => $this->tagline,
            'logoImage' => Media::url($this->logo_image),
            'favicon' => Media::url($this->favicon),
            'heroImage' => Media::url($this->hero_image),
            'heroVideo' => Media::url($this->hero_video),
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'socials' => [
                'instagram' => $this->instagram_url,
                'linkedin' => $this->linkedin_url,
                'facebook' => $this->facebook_url,
            ],
        ];
    }
}
