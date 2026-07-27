<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; 
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;


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
    Blade::directive('layout', function () {
        return "<?php echo Auth::user()->role === 'admin'
            ? view('layouts.app')
            : view('layouts.userapp'); ?>";
    });

    View::composer('*', function ($view) {
        if (!Auth::check()) return;

        $view->with([
            'topbarNotifications' => Notification::where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get(),

            'topbarUnread' => Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->count(),
        ]);
    });
}

}

