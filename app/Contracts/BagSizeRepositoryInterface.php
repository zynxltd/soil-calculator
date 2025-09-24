<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface for bag size repository
 */
interface BagSizeRepositoryInterface
{
    /**
     * Get all active bag sizes
     */
    public function getActiveBags(): Collection;

    /**
     * Get bags sorted by weight (largest first)
     */
    public function getBagsSortedByWeight(): Collection;

    /**
     * Get bags sorted by price per kg (cheapest first)
     */
    public function getBagsSortedByPricePerKg(): Collection;

    /**
     * Get smallest bag
     */
    public function getSmallestBag(): ?array;
}
