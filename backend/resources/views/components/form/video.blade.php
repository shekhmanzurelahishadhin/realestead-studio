@props([
    'name',
    'value' => null,
    'label' => 'Video',
    'hint' => null,
    'required' => false,
    'poster' => null,
    'maxKb' => null,
    'archive' => [],
])

@php
    $current = old($name, $value);
    $preview = \App\Support\Media::url($current);
    $posterUrl = \App\Support\Media::url($poster);
    $maxLabel = $maxKb ? round($maxKb / 1024).' MB' : null;
@endphp

<div x-data="{
        preview: @js($preview),
        objectUrl: null,
        // Re-pointing <video> at a new file needs an explicit load(); changing
        // the src alone leaves the previously decoded frames on screen.
        show(url) {
            if (this.objectUrl) {
                URL.revokeObjectURL(this.objectUrl);
                this.objectUrl = null;
            }
            this.preview = url || null;
            this.$nextTick(() => this.$refs.player?.load());
        },
        pick(event) {
            const file = event.target.files[0];
            if (! file) return;
            this.objectUrl = URL.createObjectURL(file);
            this.show(this.objectUrl);
        },
     }"
     {{ $attributes->merge(['class' => 'w-full']) }}>

    <label class="hz-label">
        {{ $label }}
        @if ($required)<span class="text-brand-600">*</span>@endif
    </label>

    {{-- Preview player --}}
    <div class="relative overflow-hidden rounded-2xl border border-dashed border-slate-300 bg-slate-50 dark:border-white/15 dark:bg-navy-900">
        <template x-if="preview">
            <video x-ref="player"
                   :src="preview"
                   @if ($posterUrl) poster="{{ $posterUrl }}" @endif
                   controls
                   muted
                   playsinline
                   preload="metadata"
                   class="aspect-video w-full bg-black object-cover"></video>
        </template>

        <template x-if="! preview">
            <div class="flex aspect-video w-full flex-col items-center justify-center gap-2 text-slate-300 dark:text-navy-300">
                <x-icon name="film" class="h-8 w-8"/>
                <span class="text-xs font-bold">No video set</span>
            </div>
        </template>
    </div>

    <div class="mt-3 space-y-2">
        <input type="file"
               name="{{ $name }}_file"
               accept="video/mp4,video/webm,video/ogg,video/quicktime"
               @change="pick($event)"
               class="block w-full cursor-pointer text-xs font-medium text-slate-500 file:mr-3 file:cursor-pointer
                      file:rounded-lg file:border-0 file:bg-brand-600 file:px-4 file:py-2 file:text-xs
                      file:font-bold file:text-white hover:file:bg-brand-700 dark:text-navy-200">

        <input type="text"
               name="{{ $name }}"
               id="{{ $name }}"
               x-ref="path"
               value="{{ $current }}"
               placeholder="…or paste a video URL"
               @input="show($event.target.value)"
               @class(['hz-input py-2 text-xs', 'hz-input-error' => $errors->has($name)])>
    </div>

    @error($name)
        <span class="hz-error">{{ $message }}</span>
    @else
        @error($name.'_file')
            <span class="hz-error">{{ $message }}</span>
        @else
            <span class="hz-hint">
                {{ $hint ?? 'MP4, WebM, OGG or MOV.' }}
                @if ($maxLabel) Uploads are capped at {{ $maxLabel }} by this server's PHP limits. @endif
            </span>
        @enderror
    @enderror

    {{-- Previously used files, kept by App\Support\MediaArchive. Picking one
         only rewrites the path box and the preview — nothing is copied or
         deleted until the form itself is saved. --}}
    @if (filled($archive))
        <div class="mt-5 rounded-2xl bg-[#f4f7fe] p-4 dark:bg-navy-900">
            <p class="text-xs font-bold text-navy-700 dark:text-white">Previously used</p>
            <p class="mt-0.5 text-[11px] font-medium text-slate-400 dark:text-navy-200">
                Replaced videos are kept on disk. Pick one to put it back.
            </p>

            <ul class="mt-3 space-y-2">
                @foreach ($archive as $entry)
                    <li class="flex items-center gap-3">
                        <x-icon name="film" class="h-4 w-4 shrink-0 text-slate-400"/>
                        <span class="min-w-0 flex-1">
                            <span class="block truncate text-xs font-bold text-navy-700 dark:text-white">
                                {{ basename($entry['path']) }}
                            </span>
                            <span class="block text-[11px] font-medium text-slate-400 dark:text-navy-200">
                                {{ number_format($entry['bytes'] / 1024 / 1024, 1) }} MB ·
                                replaced {{ \Illuminate\Support\Carbon::parse($entry['archived_at'])->diffForHumans() }}
                            </span>
                        </span>
                        <button type="button"
                                @click="$refs.path.value = @js($entry['path']); show(@js($entry['url']))"
                                class="shrink-0 rounded-lg px-3 py-1.5 text-[11px] font-bold text-brand-600 transition hover:bg-brand-50 dark:text-white dark:hover:bg-white/10">
                            Restore
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
