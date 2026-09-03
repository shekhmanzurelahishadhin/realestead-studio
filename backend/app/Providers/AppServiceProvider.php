<?php

namespace App\Providers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->shareAdminChrome();
    }

    /**
     * The admin shell (sidebar brand, unread badge) is rendered on every screen,
     * so those two values are composed once rather than passed by each
     * controller.
     */
    private function shareAdminChrome(): void
    {
        View::composer(['layouts.admin', 'admin.partials.*', 'admin.auth.*'], function ($view) {
            $view->with([
                'siteName' => Setting::query()->value('site_name') ?: config('app.name'),
                'unreadMessages' => ContactMessage::where('is_read', false)->count(),
            ]);
        });
    }
}
