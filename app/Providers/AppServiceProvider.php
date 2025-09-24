<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\BagSizeRepositoryInterface;
use App\Contracts\SoilCalculationServiceInterface;
use App\Contracts\BagOptimizationServiceInterface;
use App\Contracts\UnitConversionServiceInterface;
use App\Repositories\BagSizeRepository;
use App\Services\SoilCalculationService;
use App\Services\BagOptimizationService;
use App\Services\UnitConversionService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind interfaces to implementations
        $this->app->bind(BagSizeRepositoryInterface::class, BagSizeRepository::class);
        $this->app->bind(SoilCalculationServiceInterface::class, SoilCalculationService::class);
        $this->app->bind(BagOptimizationServiceInterface::class, BagOptimizationService::class);
        $this->app->bind(UnitConversionServiceInterface::class, UnitConversionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
