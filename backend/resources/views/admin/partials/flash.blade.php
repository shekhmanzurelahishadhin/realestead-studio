@php
    // `upload_error` is set by the PostTooLargeException handler in
    // bootstrap/app.php, which runs before the session exists and so cannot
    // flash a normal message. Its value is the server's limit in kilobytes.
    $uploadError = request()->filled('upload_error')
        ? 'That file is too large to upload. This server accepts at most '
            .round((int) request('upload_error') / 1024).' MB per request.'
        : null;
@endphp

@if (session('status') || session('error') || $uploadError)
    @php
        $isError = (bool) session('error') || (bool) $uploadError;
        $message = session('error') ?: ($uploadError ?: session('status'));
    @endphp
    <div x-data="{ show: true }" x-show="show" x-transition
         class="mb-6 flex items-start gap-3 rounded-[20px] px-5 py-4 shadow-card dark:shadow-card-dark
                {{ $isError ? 'bg-danger/10 text-danger' : 'bg-white text-navy-700 dark:bg-navy-800 dark:text-white' }}">
        <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full {{ $isError ? 'bg-danger text-white' : 'bg-success text-white' }}">
            <x-icon :name="$isError ? 'x' : 'check'" class="h-3.5 w-3.5"/>
        </span>
        <p class="flex-1 text-sm font-bold">{{ $message }}</p>
        <button type="button" @click="show = false" class="text-current opacity-50 transition hover:opacity-100">
            <x-icon name="x" class="h-4 w-4"/>
        </button>
    </div>
@endif

@if ($errors->any() && ! $errors->has('email'))
    <div class="mb-6 rounded-[20px] bg-danger/10 px-5 py-4">
        <p class="text-sm font-bold text-danger">Please fix the {{ $errors->count() }} highlighted field(s) below.</p>
    </div>
@endif
