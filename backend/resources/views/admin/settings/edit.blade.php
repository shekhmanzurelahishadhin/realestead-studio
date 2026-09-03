@extends('layouts.admin')

@section('title', 'Settings')
@section('heading', 'Site settings')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data"
          class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        @csrf
        @method('PUT')

        <div class="space-y-5 lg:col-span-2">
            <x-card title="Identity">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-form.field name="site_name" label="Site name" required class="sm:col-span-2">
                        <x-form.input name="site_name" :value="$setting->site_name"/>
                    </x-form.field>

                    <x-form.field name="tagline" label="Tagline" class="sm:col-span-2">
                        <x-form.textarea name="tagline" :rows="3" :value="$setting->tagline"/>
                    </x-form.field>
                </div>
            </x-card>

            <x-card title="Contact">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-form.field name="email" label="Email">
                        <x-form.input name="email" type="email" :value="$setting->email"/>
                    </x-form.field>

                    <x-form.field name="phone" label="Phone">
                        <x-form.input name="phone" :value="$setting->phone"/>
                    </x-form.field>

                    <x-form.field name="address" label="Address" class="sm:col-span-2">
                        <x-form.input name="address" :value="$setting->address"/>
                    </x-form.field>
                </div>
            </x-card>

            <x-card title="Social" subtitle="Full URLs including https://. Leave blank to hide the link.">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <x-form.field name="instagram_url" label="Instagram">
                        <x-form.input name="instagram_url" type="url" :value="$setting->instagram_url"/>
                    </x-form.field>

                    <x-form.field name="linkedin_url" label="LinkedIn">
                        <x-form.input name="linkedin_url" type="url" :value="$setting->linkedin_url"/>
                    </x-form.field>

                    <x-form.field name="facebook_url" label="Facebook">
                        <x-form.input name="facebook_url" type="url" :value="$setting->facebook_url"/>
                    </x-form.field>
                </div>
            </x-card>
        </div>

        <div class="space-y-5">
            <x-card title="Branding">
                <div class="space-y-6">
                    <x-form.image name="logo_image" :value="$setting->logo_image" label="Logo"
                                  hint="Leave empty to show the site name as a text wordmark."/>
                    <x-form.image name="favicon" :value="$setting->favicon" label="Favicon"/>
                </div>
            </x-card>

            <x-card title="Hero">
                <div class="space-y-6">
                    <x-form.image name="hero_image" :value="$setting->hero_image" label="Hero image" required/>

                    <x-form.video name="hero_video" :value="$setting->hero_video" label="Hero video"
                                  :poster="$setting->hero_image"
                                  :max-kb="$maxUploadKb"
                                  :archive="$videoArchive"
                                  hint="Optional background video; the hero image is the poster frame."/>
                </div>
            </x-card>

            <div class="hz-card space-y-3">
                <button type="submit" class="hz-btn-primary w-full">
                    <x-icon name="check" class="h-4 w-4"/> Save settings
                </button>
                <a href="{{ route('admin.dashboard') }}" class="hz-btn-ghost w-full">Cancel</a>
            </div>
        </div>
    </form>
@endsection
