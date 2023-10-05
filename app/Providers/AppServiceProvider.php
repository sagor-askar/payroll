<?php

namespace App\Providers;

use App\Models\AttLog;
use App\Observers\AttLogObserver;
use Faker\Core\Number;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        
    }
    public function boot()
    {
        
        Paginator::useBootstrap();

    }
}
