@extends('layouts.admin')

@section('title', 'Properties')
@section('heading', $property->exists ? 'Edit property' : 'New property')

@section('content')
    <form method="POST" enctype="multipart/form-data"
          action="{{ $property->exists ? route('admin.properties.update', $property) : route('admin.properties.store') }}"
          class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        @csrf
        @if ($property->exists) @method('PUT') @endif

        <div class="space-y-5 lg:col-span-2">
            <x-card title="Details">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-form.field name="title" label="Title" required class="sm:col-span-2">
                        <x-form.input name="title" :value="$property->title" placeholder="Skyline Residence"/>
                    </x-form.field>

                    <x-form.field name="slug" label="Slug" hint="Leave blank to derive it from the title.">
                        <x-form.input name="slug" :value="$property->slug" placeholder="skyline-residence"/>
                    </x-form.field>

                    <x-form.field name="location" label="Location" required>
                        <x-form.input name="location" :value="$property->location" placeholder="Gulshan, Dhaka"/>
                    </x-form.field>

                    <x-form.field name="price" label="Price" hint="Whole number, no separators.">
                        <x-form.input name="price" type="number" :value="$property->price" placeholder="1850000"/>
                    </x-form.field>

                    <x-form.field name="price_label" label="Price label" hint="Shown instead of the number, e.g. “Price on request”.">
                        <x-form.input name="price_label" :value="$property->price_label"/>
                    </x-form.field>

                    <x-form.field name="bedrooms" label="Bedrooms">
                        <x-form.input name="bedrooms" type="number" :value="$property->bedrooms"/>
                    </x-form.field>

                    <x-form.field name="bathrooms" label="Bathrooms">
                        <x-form.input name="bathrooms" type="number" :value="$property->bathrooms"/>
                    </x-form.field>

                    <x-form.field name="area" label="Area (ft²)">
                        <x-form.input name="area" type="number" :value="$property->area"/>
                    </x-form.field>

                    <x-form.field name="status" label="Status" required>
                        <x-form.select name="status" :value="$property->status"
                                       :options="\App\Http\Controllers\Admin\PropertyController::STATUSES"/>
                    </x-form.field>
                </div>
            </x-card>

            <x-card title="Gallery">
                <x-form.gallery name="gallery" :value="$property->gallery ?? []" label="Images"/>
            </x-card>

            <x-card title="Amenities" subtitle="One per line.">
                <x-form.field name="amenities">
                    <x-form.textarea name="amenities" :rows="6"
                                     :value="implode(PHP_EOL, $property->amenities ?? [])"
                                     placeholder="Rooftop pool&#10;Private lift lobby&#10;Concierge"/>
                </x-form.field>
            </x-card>
        </div>

        <div class="space-y-5">
            <x-card title="Media">
                <x-form.image name="image" :value="$property->image" label="Cover image" required/>
            </x-card>

            <x-card title="Ordering">
                <x-form.field name="sort_order" label="Sort order" hint="Lower numbers appear first.">
                    <x-form.input name="sort_order" type="number" :value="$property->sort_order ?? 0"/>
                </x-form.field>
            </x-card>

            @include('admin.partials.form-actions', ['cancel' => route('admin.properties.index'), 'model' => $property])
        </div>
    </form>

    @include('admin.partials.delete-card', [
        'model' => $property,
        'delete' => $property->exists ? route('admin.properties.destroy', $property) : null,
    ])
@endsection
