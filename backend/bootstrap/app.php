<?php

use App\Support\Media;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // The only guarded area is the admin panel, and its sign-in route is
        // "admin.login" rather than the framework's default "login".
        $middleware->redirectGuestsTo(fn () => route('admin.login'));
        $middleware->redirectUsersTo(fn () => route('admin.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // A file bigger than post_max_size is discarded by PHP before any
        // validation rule runs, so without this the panel answers a video
        // upload with a bare 413 page and no explanation.
        //
        // ValidatePostSize sits ahead of StartSession in the global stack, so
        // there is no session here: no back(), no flash. The message is carried
        // back on the query string instead and rendered by admin.partials.flash.
        $exceptions->render(function (PostTooLargeException $e, Request $request) {
            if ($request->expectsJson()) {
                return null;
            }

            $referer = (string) $request->headers->get('referer');
            $origin = $request->getSchemeAndHttpHost().'/';

            // Only ever bounce back to our own pages, never to an attacker's
            // referer, and drop any existing query string first.
            $target = str_starts_with($referer, $origin)
                ? Str::before($referer, '?')
                : route('admin.dashboard');

            return redirect()->to($target.'?upload_error='.Media::maxUploadKilobytes());
        });
    })->create();
