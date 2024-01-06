<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use the factory to create products 'A', 'B', and 'C'
        Product::factory()->create(['title' => 'A']);
        Product::factory()->create(['title' => 'B']);
        Product::factory()->create(['title' => 'C']);
    }
}
