<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share execution time globally
        View::composer('*', function ($view) {
            $executionTime = app()->bound('executionTime') ? app('executionTime') : null;
            $view->with('executionTime', $executionTime);
        });
    }
}