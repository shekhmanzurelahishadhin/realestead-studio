<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In · {{ $siteName ?? config('app.name') }}</title>

    <script>
        try {
            const stored = localStorage.getItem('hz-theme');
            if (stored === 'dark' || (!stored && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        } catch (e) {}
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
<div class="flex min-h-screen">

    {{-- Form --}}
    <div class="flex w-full flex-col justify-center px-6 sm:px-16 lg:w-1/2 xl:px-24">
        <div class="mx-auto w-full max-w-sm">
            <h1 class="text-4xl font-bold text-navy-700 dark:text-white">Sign In</h1>
            <p class="mt-2 text-base font-medium text-slate-400 dark:text-navy-200">
                Enter your email and password to manage {{ $siteName ?? config('app.name') }}.
            </p>

            <form method="POST" action="{{ route('admin.login') }}" class="mt-8 space-y-5">
                @csrf

                <x-form.field name="email" label="Email" required>
                    <x-form.input name="email" type="email" autocomplete="username" autofocus placeholder="you@example.com"/>
                </x-form.field>

                <x-form.field name="password" label="Password" required>
                    <x-form.input name="password" type="password" autocomplete="current-password" placeholder="Min. 8 characters"/>
                </x-form.field>

                <label class="flex cursor-pointer items-center gap-2 text-sm font-medium text-navy-700 dark:text-white">
                    <input type="checkbox" name="remember" value="1" @checked(old('remember'))
                           class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500 dark:border-white/20 dark:bg-navy-800">
                    Keep me logged in
                </label>

                <button type="submit" class="hz-btn-primary w-full">Sign In</button>
            </form>

            <p class="mt-8 text-xs font-medium text-slate-400 dark:text-navy-200">
                No account yet? Create one from the CLI with
                <code class="rounded bg-slate-100 px-1.5 py-0.5 dark:bg-white/10">php artisan admin:create</code>.
            </p>
        </div>
    </div>

    {{-- Brand panel --}}
    <div class="relative hidden overflow-hidden bg-brand-600 lg:block lg:w-1/2">
        <div class="absolute inset-0 bg-gradient-to-br from-brand-500 via-brand-600 to-navy-900"></div>
        <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 h-96 w-96 rounded-full bg-brand-300/20 blur-3xl"></div>
        <div class="relative flex h-full flex-col items-center justify-center px-16 text-center">
            <p class="text-5xl font-bold tracking-tight text-white">{{ $siteName ?? config('app.name') }}</p>
            <p class="mt-4 max-w-sm text-base font-medium text-white/70">
                The admin panel for your properties, projects and everything the public site shows.
            </p>
        </div>
    </div>
</div>
</body>
</html>
