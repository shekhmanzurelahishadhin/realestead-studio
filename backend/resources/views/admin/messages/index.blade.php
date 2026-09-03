@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
    <x-card>
        <div class="mb-6 flex flex-wrap items-center gap-3">
            <form method="GET" class="flex flex-1 flex-wrap items-center gap-3">
                <label class="relative min-w-56 flex-1">
                    <x-icon name="search" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"/>
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search name, email or subject…"
                           class="hz-input rounded-full bg-[#f4f7fe] py-2.5 pl-11 dark:bg-navy-900">
                </label>
                <input type="hidden" name="filter" value="{{ request('filter') }}">
            </form>

            <div class="flex items-center gap-1 rounded-full bg-[#f4f7fe] p-1 dark:bg-navy-900">
                @foreach (['' => 'All', 'unread' => 'Unread', 'read' => 'Read'] as $value => $label)
                    <a href="{{ route('admin.messages.index', array_filter(['q' => request('q'), 'filter' => $value])) }}"
                       class="rounded-full px-4 py-2 text-xs font-bold transition
                              {{ request('filter', '') === $value ? 'bg-white text-navy-700 shadow-sm dark:bg-navy-700 dark:text-white' : 'text-slate-400 hover:text-navy-700 dark:hover:text-white' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        @if ($messages->isEmpty())
            <x-empty-state message="No messages match this view."/>
        @else
            <div class="-mx-2 overflow-x-auto">
                <table class="w-full min-w-[720px] border-collapse">
                    <thead>
                        <tr>
                            <th class="hz-th">From</th>
                            <th class="hz-th">Subject</th>
                            <th class="hz-th">Received</th>
                            <th class="hz-th"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr class="transition hover:bg-[#f4f7fe] dark:hover:bg-white/5">
                                <td class="hz-td">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center gap-3">
                                        @unless ($message->is_read)
                                            <span class="h-2 w-2 shrink-0 rounded-full bg-danger" title="Unread"></span>
                                        @else
                                            <span class="h-2 w-2 shrink-0"></span>
                                        @endunless
                                        <span class="min-w-0">
                                            <span class="block truncate {{ $message->is_read ? 'font-medium' : 'font-bold' }}">{{ $message->name }}</span>
                                            <span class="block truncate text-xs font-medium text-slate-400 dark:text-navy-200">{{ $message->email }}</span>
                                        </span>
                                    </a>
                                </td>
                                <td class="hz-td">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="block min-w-0">
                                        <span class="block truncate {{ $message->is_read ? 'font-medium' : 'font-bold' }}">
                                            {{ $message->subject ?: '(no subject)' }}
                                        </span>
                                        <span class="block truncate text-xs font-medium text-slate-400 dark:text-navy-200">
                                            {{ \Illuminate\Support\Str::limit($message->message, 70) }}
                                        </span>
                                    </a>
                                </td>
                                <td class="hz-td whitespace-nowrap text-slate-500 dark:text-navy-100">
                                    {{ $message->created_at->format('j M Y, H:i') }}
                                </td>
                                <td class="hz-td">
                                    <div class="flex items-center justify-end gap-1">
                                        <form method="POST" action="{{ route('admin.messages.toggle', $message) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" title="{{ $message->is_read ? 'Mark unread' : 'Mark read' }}"
                                                    class="rounded-lg p-2 text-slate-400 transition hover:bg-brand-50 hover:text-brand-600 dark:hover:bg-white/10 dark:hover:text-white">
                                                <x-icon :name="$message->is_read ? 'inbox' : 'check'" class="h-4 w-4"/>
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.messages.show', $message) }}" title="Read"
                                           class="rounded-lg p-2 text-slate-400 transition hover:bg-brand-50 hover:text-brand-600 dark:hover:bg-white/10 dark:hover:text-white">
                                            <x-icon name="eye" class="h-4 w-4"/>
                                        </a>
                                        <x-delete-button :action="route('admin.messages.destroy', $message)"
                                                         confirm="Delete this message permanently?"/>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $messages->links() }}</div>
        @endif
    </x-card>
@endsection
