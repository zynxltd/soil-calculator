<?php

namespace App\Services;

use App\Contracts\SoilCalculationServiceInterface;

/**
 * Service for soil calculation business logic
 */
class SoilCalculationService implements SoilCalculationServiceInterface
{
    private const TONNES_TO_KG = 1000;
    private const LITERS_PER_CUBIC_METER = 1000;

    private array $soilDensities;

    public function __construct()
    {
        $this->soilDensities = config('soil.densities', [
            'intensive' => 1.3,
            'extensive' => 1.1,
        ]);
    }

    public function calculateVolume(float $length, float $width, float $depth): float
    {
        return $length * $width * $depth;
    }

    public function calculateSoilRequired(float $volume, string $soilType): float
    {
        $density = $this->getSoilDensity($soilType);
        return $volume * $density * self::TONNES_TO_KG;
    }

    public function getSoilTypes(): array
    {
        return [
            'intensive' => 'Intensive (' . $this->soilDensities['intensive'] . ' tonnes/m³)',
            'extensive' => 'Extensive (' . $this->soilDensities['extensive'] . ' tonnes/m³)',
        ];
    }

    public function getSoilDensity(string $soilType): float
    {
        if (!isset($this->soilDensities[$soilType])) {
            throw new \InvalidArgumentException("Invalid soil type: {$soilType}");
        }

        return $this->soilDensities[$soilType];
    }

    public function calculateLiters(float $volume): int
    {
        return (int) round($volume * self::LITERS_PER_CUBIC_METER);
    }
}
