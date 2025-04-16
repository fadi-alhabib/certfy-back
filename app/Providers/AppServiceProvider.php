<?php

namespace App\Providers;

use App\Http\Services\MemoryImageService;
use App\Services\Common\Contracts\ImageServiceInterface;

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
