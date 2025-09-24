<?php

namespace App\Repositories;

use App\Contracts\BagSizeRepositoryInterface;
use App\Models\BagSize;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository for bag size data access
 */
class BagSizeRepository implements BagSizeRepositoryInterface
{
    public function getActiveBags(): Collection
    {
        return BagSize::active()->ordered()->get();
    }

    public function getBagsSortedByWeight(): Collection
    {
        return BagSize::active()
            ->orderBy('weight', 'desc')
            ->get();
    }

    public function getBagsSortedByPricePerKg(): Collection
    {
        return BagSize::active()
            ->get()
            ->sortBy(function ($bag) {
                return $bag->price / $bag->weight;
            })
            ->values();
    }

    public function getSmallestBag(): ?array
    {
        $bag = BagSize::active()
            ->orderBy('weight')
            ->first();

        if (!$bag) {
            return null;
        }

        return [
            'name' => $bag->name,
            'weight' => (float) $bag->weight,
            'price' => (float) $bag->price,
        ];
    }
}
