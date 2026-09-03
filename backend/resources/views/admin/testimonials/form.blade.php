@extends('layouts.admin')

@section('title', 'Testimonials')
@section('heading', $testimonial->exists ? 'Edit testimonial' : 'New testimonial')

@section('content')
    <form method="POST"
          action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}"
          class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        @csrf
        @if ($testimonial->exists) @method('PUT') @endif

        <div class="lg:col-span-2">
            <x-card title="Details">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-form.field name="quote" label="Quote" required class="sm:col-span-2">
                        <x-form.textarea name="quote" :rows="5" :value="$testimonial->quote"
                                         placeholder="They turned a difficult site into the calmest home we have lived in."/>
                    </x-form.field>

                    <x-form.field name="name" label="Client name" required>
                        <x-form.input name="name" :value="$testimonial->name"/>
                    </x-form.field>

                    <x-form.field name="role" label="Role" hint="Job title or relationship, e.g. “Homeowner”.">
                        <x-form.input name="role" :value="$testimonial->role"/>
                    </x-form.field>

                    <x-form.field name="project" label="Project" hint="Free text — the project this quote is about.">
                        <x-form.input name="project" :value="$testimonial->project"/>
                    </x-form.field>

                    <x-form.field name="sort_order" label="Sort order" hint="Lower numbers appear first.">
                        <x-form.input name="sort_order" type="number" :value="$testimonial->sort_order ?? 0"/>
                    </x-form.field>
                </div>
            </x-card>
        </div>

        <div class="space-y-5">
            @include('admin.partials.form-actions', ['cancel' => route('admin.testimonials.index'), 'model' => $testimonial])
        </div>
    </form>

    @include('admin.partials.delete-card', [
        'model' => $testimonial,
        'delete' => $testimonial->exists ? route('admin.testimonials.destroy', $testimonial) : null,
    ])
@endsection
