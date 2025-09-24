<?php

namespace App\Contracts;

/**
 * Interface for soil calculation services
 */
interface SoilCalculationServiceInterface
{
    /**
     * Calculate volume in cubic meters
     */
    public function calculateVolume(float $length, float $width, float $depth): float;

    /**
     * Calculate soil required in kg
     */
    public function calculateSoilRequired(float $volume, string $soilType): float;

    /**
     * Get available soil types
     */
    public function getSoilTypes(): array;

    /**
     * Get soil density for a given type
     */
    public function getSoilDensity(string $soilType): float;
}
