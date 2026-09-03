@props([
    'name',
    'value' => [],
    'label' => 'Gallery',
    'hint' => null,
])

@php
    // Existing images keep their stored path; the browser only ever sees the
    // resolved URL, so both travel together.
    $existing = collect(old($name, $value) ?? [])
        ->filter(fn ($path) => filled($path))
        ->map(fn ($path) => ['path' => $path, 'url' => \App\Support\Media::url($path)])
        ->values()
        ->all();
@endphp

<div x-data="{
        /* Images already stored on the record, in display order. */
        kept: @js($existing),
        /* Files picked in this browser session, previewed but not yet uploaded. */
        picked: [],
        dragIndex: null,

        remove(index) {
            this.kept.splice(index, 1);
        },

        /* Reordering the array reorders the hidden inputs, which is what the
           controller reads — no separate sort field is needed. */
        drop(index) {
            if (this.dragIndex === null || this.dragIndex === index) return;
            const [moved] = this.kept.splice(this.dragIndex, 1);
            this.kept.splice(index, 0, moved);
            this.dragIndex = null;
        },

        add(event) {
            for (const file of event.target.files) {
                this.picked.push({ name: file.name, url: URL.createObjectURL(file) });
            }
            this.sync(event.target);
        },

        /* A file input's list is read-only, so dropping one file means
           rebuilding the whole FileList from what is left. */
        unpick(index) {
            URL.revokeObjectURL(this.picked[index].url);
            this.picked.splice(index, 1);
            const input = this.$refs.files;
            const data = new DataTransfer();
            [...input.files].forEach((file, i) => i !== index && data.items.add(file));
            input.files = data.files;
            this.sync(input);
        },

        sync(input) {
            this.picked = this.picked.slice(0, input.files.length);
        },
     }"
     {{ $attributes->merge(['class' => 'w-full']) }}>

    <div class="mb-2 flex items-baseline justify-between gap-3">
        <label class="hz-label mb-0">{{ $label }}</label>
        <span class="text-xs font-medium text-slate-400 dark:text-navy-200"
              x-text="(kept.length + picked.length) + ' image' + (kept.length + picked.length === 1 ? '' : 's')"></span>
    </div>

    <div class="rounded-2xl border border-dashed border-slate-300 p-4 dark:border-white/15">
        <div class="grid grid-cols-3 gap-3 sm:grid-cols-4"
             x-show="kept.length || picked.length" style="display: none">

            {{-- Stored images: draggable, removable, each backed by a hidden input --}}
            <template x-for="(item, index) in kept" :key="item.path">
                <div class="group relative aspect-square overflow-hidden rounded-xl bg-slate-100 dark:bg-navy-900"
                     draggable="true"
                     @dragstart="dragIndex = index"
                     @dragover.prevent
                     @drop.prevent="drop(index)"
                     :class="dragIndex === index ? 'opacity-40' : ''">
                    <input type="hidden" :name="'{{ $name }}[]'" :value="item.path">
                    <img :src="item.url" alt="" class="h-full w-full cursor-move object-cover">
                    <button type="button" @click="remove(index)" title="Remove"
                            class="absolute right-1.5 top-1.5 rounded-lg bg-navy-900/70 p-1.5 text-white opacity-0 transition
                                   hover:bg-danger group-hover:opacity-100 focus:opacity-100">
                        <x-icon name="x" class="h-3.5 w-3.5"/>
                    </button>
                </div>
            </template>

            {{-- Newly picked files: preview only until the form is saved --}}
            <template x-for="(item, index) in picked" :key="item.url">
                <div class="group relative aspect-square overflow-hidden rounded-xl ring-2 ring-brand-500">
                    <img :src="item.url" alt="" class="h-full w-full object-cover">
                    <span class="absolute inset-x-0 bottom-0 bg-brand-600 py-0.5 text-center text-[10px] font-bold text-white">New</span>
                    <button type="button" @click="unpick(index)" title="Remove"
                            class="absolute right-1.5 top-1.5 rounded-lg bg-navy-900/70 p-1.5 text-white opacity-0 transition
                                   hover:bg-danger group-hover:opacity-100 focus:opacity-100">
                        <x-icon name="x" class="h-3.5 w-3.5"/>
                    </button>
                </div>
            </template>
        </div>

        <p x-show="! kept.length && ! picked.length"
           class="py-6 text-center text-xs font-bold text-slate-400 dark:text-navy-200">
            No images yet
        </p>

        <input type="file"
               x-ref="files"
               name="{{ $name }}_files[]"
               accept="image/*"
               multiple
               @change="add($event)"
               class="mt-4 block w-full cursor-pointer text-xs font-medium text-slate-500 file:mr-3 file:cursor-pointer
                      file:rounded-lg file:border-0 file:bg-brand-600 file:px-4 file:py-2 file:text-xs
                      file:font-bold file:text-white hover:file:bg-brand-700 dark:text-navy-200">
    </div>

    @error($name)
        <span class="hz-error">{{ $message }}</span>
    @else
        @error($name.'_files.*')
            <span class="hz-error">{{ $message }}</span>
        @else
            <span class="hz-hint">{{ $hint ?? 'Select several files at once. Drag a thumbnail to reorder; the first image leads the gallery.' }}</span>
        @enderror
    @enderror
</div>
