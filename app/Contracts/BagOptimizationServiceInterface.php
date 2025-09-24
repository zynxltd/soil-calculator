<?php

namespace App\Contracts;

/**
 * Interface for bag optimization services
 */
interface BagOptimizationServiceInterface
{
    /**
     * Find optimal bag combination
     */
    public function findOptimalCombination(float $requiredKg, string $optimizeBy = 'wastage'): array;

    /**
     * Get fallback combination when no optimal solution is found
     */
    public function getFallbackCombination(float $requiredKg): array;
}
