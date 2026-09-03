<?php

namespace App\Support;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * Replacing a media field only overwrites the *reference* on the record — the
 * old file stays on the public disk. Because uploads are stored under a random
 * hashed name, though, an unreferenced file is effectively unrecoverable: there
 * is nothing left that says what it was.
 *
 * This keeps a small JSON manifest of every file that has been replaced, so the
 * previous hero video (or any other archived field) can still be found and put
 * back later. The manifest lives on the private disk; the files themselves are
 * never moved or deleted.
 */
class MediaArchive
{
    /** Relative to the "local" (private) disk. */
    private const MANIFEST = 'media-archive.json';

    /** Entries kept per field, newest first. */
    private const KEEP = 20;

    /**
     * Record that `$previous` is no longer the live value of `$field`.
     * Does nothing when the value did not actually change, when it was an
     * external URL (nothing of ours to lose), or when the file is already gone.
     */
    public static function record(string $field, ?string $previous, ?string $current): void
    {
        if (blank($previous) || $previous === $current) {
            return;
        }

        if (str_starts_with($previous, 'http://') || str_starts_with($previous, 'https://')) {
            return;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($previous)) {
            return;
        }

        $manifest = self::read();
        $entries = collect($manifest[$field] ?? [])
            ->reject(fn ($entry) => ($entry['path'] ?? null) === $previous)
            ->prepend([
                'path' => $previous,
                'bytes' => $disk->size($previous),
                'archived_at' => Carbon::now()->toIso8601String(),
            ])
            ->take(self::KEEP)
            ->values()
            ->all();

        $manifest[$field] = $entries;

        Storage::disk('local')->put(self::MANIFEST, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Previously used files for a field, newest first, skipping any whose file
     * has since been removed from disk by hand.
     *
     * @return array<int, array{path: string, url: string|null, bytes: int, archived_at: string}>
     */
    public static function for(string $field): array
    {
        $disk = Storage::disk('public');

        return collect(self::read()[$field] ?? [])
            ->filter(fn ($entry) => filled($entry['path'] ?? null) && $disk->exists($entry['path']))
            ->map(fn ($entry) => $entry + ['url' => Media::url($entry['path'])])
            ->values()
            ->all();
    }

    /** @return array<string, array<int, array<string, mixed>>> */
    private static function read(): array
    {
        $disk = Storage::disk('local');

        if (! $disk->exists(self::MANIFEST)) {
            return [];
        }

        return json_decode((string) $disk->get(self::MANIFEST), true) ?: [];
    }
}
