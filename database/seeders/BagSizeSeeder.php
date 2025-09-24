<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BagSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bagSizes = [
            [
                'name' => '25kg Standard',
                'weight' => 25.00,
                'price' => 4.00,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => '600kg Bulk Bag',
                'weight' => 600.00,
                'price' => 90.00,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => '1000kg Tonne Bag',
                'weight' => 1000.00,
                'price' => 140.00,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($bagSizes as $bagSize) {
            \DB::table('bag_sizes')->insert(array_merge($bagSize, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
