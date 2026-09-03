<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesMedia;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Media;
use App\Support\MediaArchive;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use HandlesMedia;

    /** Image columns on the singleton settings row. */
    private const IMAGES = ['logo_image', 'favicon', 'hero_image'];

    /** Video columns, validated and stored separately from the images. */
    private const VIDEOS = ['hero_video'];

    /**
     * Fields whose replaced file is kept in the archive. The hero video is the
     * one piece of media here that is expensive to re-create or re-source.
     */
    private const ARCHIVED = ['hero_video'];

    public function edit()
    {
        return view('admin.settings.edit', [
            'setting' => Setting::firstOrNew(['id' => 1], ['site_name' => config('app.name')]),
            'videoArchive' => MediaArchive::for('hero_video'),
            'maxUploadKb' => Media::maxUploadKilobytes(),
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'site_name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:2048'],
            'linkedin_url' => ['nullable', 'url', 'max:2048'],
            'facebook_url' => ['nullable', 'url', 'max:2048'],
        ];

        foreach (self::IMAGES as $field) {
            $rules += $this->mediaRules($field, required: $field === 'hero_image');
        }

        foreach (self::VIDEOS as $field) {
            $rules += $this->videoRules($field);
        }

        $data = $request->validate($rules);

        $setting = Setting::firstOrNew(['id' => 1]);
        $previous = $setting->only(self::ARCHIVED);

        // Videos go to "videos/" so they land beside the seeded hero.mp4 and
        // are covered by the same un-ignore rule in storage/app/public.
        $media = $this->media($request, self::IMAGES, 'site')
            + $this->media($request, self::VIDEOS, 'videos');

        $setting->fill(array_merge($data, $media))->save();

        foreach (self::ARCHIVED as $field) {
            MediaArchive::record($field, $previous[$field] ?? null, $setting->$field);
        }

        return redirect()->route('admin.settings.edit')->with('status', 'Site settings saved.');
    }
}
