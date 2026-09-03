<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Support\Media;
use Illuminate\Http\Request;

trait HandlesMedia
{
    /**
     * Every image field in the panel is a pair: an optional "<field>_file"
     * upload and a "<field>" text box holding a URL or an existing public-disk
     * path. An upload wins; otherwise the text value is kept as typed.
     *
     * @param  array<int, string>  $fields
     * @return array<string, string|null>
     */
    protected function media(Request $request, array $fields, string $directory): array
    {
        $values = [];

        foreach ($fields as $field) {
            if ($request->hasFile($field.'_file')) {
                $values[$field] = $request->file($field.'_file')->store($directory, 'public');

                continue;
            }

            $values[$field] = $request->input($field) ?: null;
        }

        return $values;
    }

    /**
     * A gallery is edited as thumbnails: "<field>[]" carries the images being
     * kept (in display order) and "<field>_files[]" carries newly picked ones,
     * which are stored and appended to the end.
     *
     * @return array<int, string>
     */
    protected function gallery(Request $request, string $field, string $directory): array
    {
        $kept = collect($request->input($field, []))
            ->filter(fn ($value) => is_string($value) && trim($value) !== '')
            ->map(fn ($value) => trim($value));

        $uploaded = collect($request->file($field.'_files', []))
            ->filter()
            ->map(fn ($file) => $file->store($directory, 'public'));

        return $kept->concat($uploaded)->unique()->values()->all();
    }

    /** Rules for a gallery pair. */
    protected function galleryRules(string $field): array
    {
        return [
            $field => ['nullable', 'array', 'max:60'],
            $field.'.*' => ['string', 'max:2048'],
            $field.'_files' => ['nullable', 'array', 'max:30'],
            $field.'_files.*' => ['image', 'max:8192'],
        ];
    }

    /**
     * Textarea-backed list fields (amenities, …) are edited one item per line;
     * blank lines are dropped so a stray return never becomes data.
     *
     * @return array<int, string>
     */
    protected function lines(?string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $value))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Rules shared by every image pair. `nullable` comes first because
     * ConvertEmptyStringsToNull turns an untouched URL box into null — the
     * `string` rule must skip it while `required_without` still runs.
     */
    protected function mediaRules(string $field, bool $required = false): array
    {
        return [
            $field => array_filter([
                'nullable',
                $required ? 'required_without:'.$field.'_file' : null,
                'string',
                'max:2048',
            ]),
            $field.'_file' => ['nullable', 'image', 'max:8192'],
        ];
    }

    /** Same pair as mediaRules(), for a video field. */
    protected function videoRules(string $field, bool $required = false): array
    {
        return [
            $field => array_filter([
                'nullable',
                $required ? 'required_without:'.$field.'_file' : null,
                'string',
                'max:2048',
            ]),
            $field.'_file' => [
                'nullable',
                'file',
                'mimetypes:video/mp4,video/webm,video/ogg,video/quicktime',
                'max:'.Media::maxUploadKilobytes(),
            ],
        ];
    }
}
