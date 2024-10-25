<?php

namespace App\Providers;

use App\Interfaces\Interfaces\NotificationInterface;
use App\Interfaces\Interfaces\RecordInterface;
use App\Interfaces\Interfaces\VehicleInterface;
use App\Interfaces\UserInterface;
use App\Repositories\NotificationRepository;
use App\Repositories\RecordRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(VehicleInterface::class, VehicleRepository::class);
        $this->app->bind(RecordInterface::class, RecordRepository::class);
        $this->app->bind(NotificationInterface::class, NotificationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
