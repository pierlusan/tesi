<?php

namespace App\Providers;

use App\Models\SingleEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;


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
        /**
        $user = Auth::user();
        if ($user->isAdmin()) {
            $singleEventsCount = SingleEvent::whereNotNull('date')
                ->orderByRaw("FIELD(status, 'active', 'planned', 'completed', 'canceled')")
                ->orderBy('date', 'asc')
                ->get()->count();
        } else{
            $singleEventsCount = $user->singleEvents()
                ->orderByRaw("FIELD(status, 'active', 'planned', 'completed', 'canceled')")
                ->orderBy('date', 'asc')
                ->get()->count();
        }
         **/
      /**  $pendingUsersCount = User::where('approved', 0)->count();
        View::share([
            'pendingUsersCount' => $pendingUsersCount,
            //'singleEventsCount' => $singleEventsCount,
        ]);
    }*/
}
