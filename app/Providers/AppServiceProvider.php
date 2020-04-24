<?php

namespace App\Providers;

use App\Group;
use Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        //Give all permission to superuser
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super-user')) {
                return true;
            }
        });
    }
}
