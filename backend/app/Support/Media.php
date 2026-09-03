<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class Media
{
    /**
     * Normalizes a stored image/video reference into an absolute URL.
     *
     * The admin panel's image fields save a path relative to the "public"
     * disk (e.g. "projects/abc123.jpg") when a file is uploaded, and store
     * whatever was typed when a URL is pasted; the seeders wrote paths
     * directly. All of those are valid values for the same column,
     * so every API Resource routes through here rather than assuming one
     * format.
     */
    public static function url(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        return Storage::disk('public')->url($value);
    }

    /** Same as url(), applied to each item in an array column. */
    public static function urls(?array $values): array
    {
        return array_map(fn ($v) => self::url($v), $values ?? []);
    }

    /**
     * The largest upload this server will actually accept, in kilobytes —
     * the smaller of upload_max_filesize and post_max_size.
     *
     * A file over that limit never reaches validation: PHP discards it and the
     * request arrives looking empty (or blows up with a 413). Both the "max:"
     * rule and the hint shown in the form are derived from the real limit so
     * they can never drift from it.
     */
    public static function maxUploadKilobytes(): int
    {
        $toBytes = function (string $value): int {
            $value = trim($value);
            $number = (int) $value;

            return match (strtolower(substr($value, -1))) {
                'g' => $number * 1024 ** 3,
                'm' => $number * 1024 ** 2,
                'k' => $number * 1024,
                default => $number,
            };
        };

        $limits = array_filter([
            $toBytes((string) ini_get('upload_max_filesize')),
            $toBytes((string) ini_get('post_max_size')),
        ]);

        return $limits === [] ? 8192 : (int) floor(min($limits) / 1024);
    }
}
