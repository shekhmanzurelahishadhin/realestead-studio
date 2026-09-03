<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait GeneratesSlugs
{
    /**
     * Slug is optional in the forms: leave it blank and it is derived from the
     * title, with a numeric suffix when that slug is already taken by another
     * row. An explicitly typed slug is validated for uniqueness instead.
     */
    protected function uniqueSlug(string $table, string $source, ?Model $ignore = null): string
    {
        $base = Str::slug($source) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;

        while (
            DB::table($table)
                ->where('slug', $slug)
                ->when($ignore?->getKey(), fn ($q, $id) => $q->where('id', '!=', $id))
                ->exists()
        ) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
