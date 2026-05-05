<?php

namespace Database\Seeders;

use App\Models\ProductUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductUnitSeeder extends Seeder
{
  public function run(): void
  {
    $units = [
      [
        'name' => 'Kilogram',
        'abbreviation' => 'kg',
        'description' => 'Weight measurement unit',
        'is_active' => true,
      ],
      [
        'name' => 'Gram',
        'abbreviation' => 'g',
        'description' => 'Smaller weight measurement unit',
        'is_active' => true,
      ],
      [
        'name' => 'Liter',
        'abbreviation' => 'L',
        'description' => 'Volume measurement unit',
        'is_active' => true,
      ],
      [
        'name' => 'Milliliter',
        'abbreviation' => 'ml',
        'description' => 'Smaller volume measurement unit',
        'is_active' => true,
      ],
      [
        'name' => 'Meter',
        'abbreviation' => 'm',
        'description' => 'Length measurement unit',
        'is_active' => true,
      ],
      [
        'name' => 'Centimeter',
        'abbreviation' => 'cm',
        'description' => 'Smaller length measurement unit',
        'is_active' => true,
      ],
      [
        'name' => 'Piece',
        'abbreviation' => 'pc',
        'description' => 'Individual unit count',
        'is_active' => true,
      ],
      [
        'name' => 'Dozen',
        'abbreviation' => 'dz',
        'description' => 'Group of 12 units',
        'is_active' => true,
      ],
      [
        'name' => 'Box',
        'abbreviation' => 'box',
        'description' => 'Boxed quantity',
        'is_active' => true,
      ],
      [
        'name' => 'Pack',
        'abbreviation' => 'pack',
        'description' => 'Packed quantity',
        'is_active' => true,
      ],
    ];

    foreach ($units as $unit) {
      ProductUnit::updateOrCreate(
        ['abbreviation' => $unit['abbreviation']],
        $unit
      );
    }
  }
}
