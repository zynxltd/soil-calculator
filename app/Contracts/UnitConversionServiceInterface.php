<?php

namespace App\Contracts;

/**
 * Interface for unit conversion services
 */
interface UnitConversionServiceInterface
{
    /**
     * Convert between measurement units
     */
    public function convert(float $value, string $fromUnit, string $toUnit): float;

    /**
     * Get supported units
     */
    public function getSupportedUnits(): array;
}
