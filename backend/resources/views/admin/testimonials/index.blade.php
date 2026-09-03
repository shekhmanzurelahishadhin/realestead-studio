@extends('layouts.admin')

@section('title', 'Testimonials')

@section('content')
    <x-card title="Testimonials" subtitle="Client quotes shown in the carousel.">
        <x-slot:actions>
            <a href="{{ route('admin.testimonials.create') }}" class="hz-btn-primary">
                <x-icon name="plus" class="h-4 w-4"/> New testimonial
            </a>
        </x-slot:actions>

        @if ($testimonials->isEmpty())
            <x-empty-state message="No testimonials yet."
                           :action="route('admin.testimonials.create')" action-label="Add a testimonial"/>
        @else
            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                @foreach ($testimonials as $testimonial)
                    <figure class="flex flex-col rounded-[20px] bg-[#f4f7fe] p-6 dark:bg-navy-900">
                        <x-icon name="quote" class="h-6 w-6 text-brand-600"/>

                        <blockquote class="mt-4 flex-1 text-sm font-medium leading-relaxed text-navy-700 dark:text-white">
                            “{{ $testimonial->quote }}”
                        </blockquote>

                        <figcaption class="mt-5 flex items-center gap-3 border-t border-slate-200 pt-4 dark:border-white/10">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-600 text-xs font-bold text-white">
                                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($testimonial->name, 0, 2)) }}
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block truncate text-sm font-bold text-navy-700 dark:text-white">{{ $testimonial->name }}</span>
                                <span class="block truncate text-xs font-medium text-slate-400 dark:text-navy-200">
                                    {{ collect([$testimonial->role, $testimonial->project])->filter()->implode(' · ') }}
                                </span>
                            </span>
                            <x-row-actions :edit="route('admin.testimonials.edit', $testimonial)"
                                           :delete="route('admin.testimonials.destroy', $testimonial)"/>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        @endif
    </x-card>
@endsection
