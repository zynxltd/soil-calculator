<?php

namespace App\Services;

use App\Contracts\UnitConversionServiceInterface;

/**
 * Service for unit conversion operations
 */
class UnitConversionService implements UnitConversionServiceInterface
{
    private const CONVERSION_FACTORS = [
        'meters' => 1.0,
        'feet' => 0.3048,
        'inches' => 0.0254,
    ];

    public function convert(float $value, string $fromUnit, string $toUnit): float
    {
        $this->validateUnits($fromUnit, $toUnit);

        // Convert to meters first
        $meters = $value * self::CONVERSION_FACTORS[$fromUnit];

        // Convert from meters to target unit
        return $meters / self::CONVERSION_FACTORS[$toUnit];
    }

    public function getSupportedUnits(): array
    {
        return array_keys(self::CONVERSION_FACTORS);
    }

    private function validateUnits(string $fromUnit, string $toUnit): void
    {
        if (!isset(self::CONVERSION_FACTORS[$fromUnit])) {
            throw new \InvalidArgumentException("Unsupported from unit: {$fromUnit}");
        }

        if (!isset(self::CONVERSION_FACTORS[$toUnit])) {
            throw new \InvalidArgumentException("Unsupported to unit: {$toUnit}");
        }
    }
}
