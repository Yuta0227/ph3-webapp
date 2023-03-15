<?php

namespace App\Providers;

use App\Http\Composers\WebappComposer;
use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;

class WebappServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('webapp',WebappComposer::class);
    }
}
