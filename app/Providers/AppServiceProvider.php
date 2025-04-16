<?php

namespace App\Providers;

use App\Services\Common\Contracts\ImageServiceInterface;
use App\Services\Common\MemoryImageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ImageServiceInterface::class, MemoryImageService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
