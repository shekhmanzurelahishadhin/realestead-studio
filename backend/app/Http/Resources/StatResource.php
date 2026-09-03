<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'value' => (float) $this->value,
            'suffix' => $this->suffix,
            'label' => $this->label,
        ];
    }
}
