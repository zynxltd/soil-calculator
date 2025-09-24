<?php

namespace App\Services;

use App\Contracts\BagOptimizationServiceInterface;
use App\Contracts\BagSizeRepositoryInterface;

/**
 * Service for bag optimization algorithms
 */
class BagOptimizationService implements BagOptimizationServiceInterface
{
    public function __construct(
        private BagSizeRepositoryInterface $bagSizeRepository
    ) {}

    public function findOptimalCombination(float $requiredKg, string $optimizeBy = 'wastage'): array
    {
        $bags = $this->getSortedBags($optimizeBy);
        
        return $this->getSimpleCombination($bags, $requiredKg, $optimizeBy);
    }

    public function getFallbackCombination(float $requiredKg): array
    {
        $smallestBag = $this->bagSizeRepository->getSmallestBag();
        
        if (!$smallestBag) {
            throw new \RuntimeException('No bag sizes available');
        }

        $count = (int) ceil($requiredKg / $smallestBag['weight']);
        $totalWeight = $count * $smallestBag['weight'];
        $wastage = (($totalWeight - $requiredKg) / $requiredKg) * 100;

        return [
            'bags' => [[
                'count' => $count,
                'weight' => $smallestBag['weight'],
                'price' => $smallestBag['price'],
                'name' => $smallestBag['name']
            ]],
            'total_weight' => $totalWeight,
            'total_cost' => $count * $smallestBag['price'],
            'wastage_percentage' => round($wastage, 1),
            'wastage_kg' => round($totalWeight - $requiredKg, 2)
        ];
    }

    private function getSortedBags(string $optimizeBy): array
    {
        if ($optimizeBy === 'cost') {
            return $this->bagSizeRepository->getBagsSortedByPricePerKg()->toArray();
        }

        return $this->bagSizeRepository->getBagsSortedByWeight()->toArray();
    }

    private function getSimpleCombination(array $bags, float $requiredKg, string $optimizeBy): array
    {
        $bagCounts = [];
        $remaining = $requiredKg;
        $totalCost = 0;

        // Use greedy approach: always pick the largest bag that fits
        foreach ($bags as $bag) {
            if ($remaining <= 0) break;
            
            $count = (int) floor($remaining / $bag['weight']);
            if ($count > 0) {
                $bagKey = $bag['name'];
                $bagCounts[$bagKey] = ($bagCounts[$bagKey] ?? 0) + $count;
                $remaining -= $count * $bag['weight'];
                $totalCost += $count * $bag['price'];
            }
        }
        
        // If there's still remaining, add one more of the smallest bag
        if ($remaining > 0 && !empty($bags)) {
            $smallestBag = end($bags);
            $bagKey = $smallestBag['name'];
            $bagCounts[$bagKey] = ($bagCounts[$bagKey] ?? 0) + 1;
            $remaining -= $smallestBag['weight'];
            $totalCost += $smallestBag['price'];
        }
        
        // Convert bag counts back to combination array
        $combination = [];
        foreach ($bagCounts as $bagName => $count) {
            $bag = collect($bags)->firstWhere('name', $bagName);
            if ($bag) {
                $combination[] = [
                    'count' => $count,
                    'weight' => $bag['weight'],
                    'price' => $bag['price'],
                    'name' => $bag['name']
                ];
            }
        }
        
        $totalWeight = array_sum(array_map(fn($bag) => $bag['count'] * $bag['weight'], $combination));
        $wastage = (($totalWeight - $requiredKg) / $requiredKg) * 100;
        
        return [
            'bags' => $combination,
            'total_weight' => $totalWeight,
            'total_cost' => $totalCost,
            'wastage_percentage' => round($wastage, 1),
            'wastage_kg' => round($totalWeight - $requiredKg, 2)
        ];
    }
}
