<?php

namespace App\Providers;

use App\Contracts\IUser;
use App\Contracts\IVideo;
use App\Repositories\UserRepository;
use App\Repositories\VideoRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUser::class, UserRepository::class);
        $this->app->bind(IVideo::class, VideoRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
