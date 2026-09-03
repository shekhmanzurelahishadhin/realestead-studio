@extends('layouts.admin')

@section('title', 'Messages')
@section('heading', $message->subject ?: 'Message')

@section('content')
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        <x-card class="lg:col-span-2">
            <div class="flex flex-wrap items-center gap-4 border-b border-slate-100 pb-5 dark:border-white/5">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-brand-600 text-sm font-bold text-white">
                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($message->name, 0, 2)) }}
                </span>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-base font-bold text-navy-700 dark:text-white">{{ $message->name }}</p>
                    <p class="truncate text-sm font-medium text-slate-400 dark:text-navy-200">
                        <a href="mailto:{{ $message->email }}" class="hover:underline">{{ $message->email }}</a>
                        @if ($message->phone)
                            · <a href="tel:{{ $message->phone }}" class="hover:underline">{{ $message->phone }}</a>
                        @endif
                    </p>
                </div>
                <span class="shrink-0 text-xs font-medium text-slate-400 dark:text-navy-200">
                    {{ $message->created_at->format('j M Y, H:i') }}
                </span>
            </div>

            <p class="mt-6 whitespace-pre-line text-sm font-medium leading-relaxed text-navy-700 dark:text-white">{{ $message->message }}</p>
        </x-card>

        <div class="space-y-5">
            <x-card title="Actions">
                <div class="space-y-3">
                    <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: '.($message->subject ?: 'Your enquiry')) }}"
                       class="hz-btn-primary w-full">Reply by email</a>

                    <form method="POST" action="{{ route('admin.messages.toggle', $message) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="hz-btn-ghost w-full">
                            {{ $message->is_read ? 'Mark as unread' : 'Mark as read' }}
                        </button>
                    </form>

                    <a href="{{ route('admin.messages.index') }}" class="hz-btn-ghost w-full">
                        <x-icon name="arrow-left" class="h-4 w-4"/> Back to inbox
                    </a>
                </div>
            </x-card>

            @include('admin.partials.delete-card', [
                'model' => $message,
                'delete' => route('admin.messages.destroy', $message),
            ])
        </div>
    </div>
@endsection
