<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
  public function run(): void
  {
    $categories = [
      [
        'name' => 'Electronics',
        'description' => 'Electronic devices and gadgets',
        'is_active' => true,
      ],
      [
        'name' => 'Clothing & Apparel',
        'description' => 'Clothing, shoes, and fashion items',
        'is_active' => true,
      ],
      [
        'name' => 'Home & Garden',
        'description' => 'Home improvement, furniture, and garden items',
        'is_active' => true,
      ],
      [
        'name' => 'Beauty & Personal Care',
        'description' => 'Beauty products, cosmetics, and personal care items',
        'is_active' => true,
      ],
      [
        'name' => 'Food & Beverages',
        'description' => 'Food items and beverages',
        'is_active' => true,
      ],
      [
        'name' => 'Sports & Outdoors',
        'description' => 'Sports equipment and outdoor gear',
        'is_active' => true,
      ],
      [
        'name' => 'Books & Media',
        'description' => 'Books, magazines, and media items',
        'is_active' => true,
      ],
      [
        'name' => 'Toys & Entertainment',
        'description' => 'Toys, games, and entertainment products',
        'is_active' => true,
      ],
      [
        'name' => 'Tools & Hardware',
        'description' => 'Tools, hardware, and construction materials',
        'is_active' => true,
      ],
      [
        'name' => 'Arts & Crafts',
        'description' => 'Art supplies and craft materials',
        'is_active' => true,
      ],
    ];

    foreach ($categories as $category) {
      ProductCategory::updateOrCreate(
        ['name' => $category['name']],
        $category
      );
    }
  }
}
