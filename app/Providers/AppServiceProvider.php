<?php

namespace App\Providers;

use App\Models\Admin;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // Define Permissions
        Gate::define('manage_site', function(Admin $admin) {
            return $admin->hasRole('super_admin');
        });

        Gate::before(function ($admin, $ability) {
            if ($admin->hasRole('super_admin')) {
                return true;
            }
        });

        Gate::define('manage_video', function(Admin $admin) {
            return $admin->hasRole('video_editor');
        });

    }
}
