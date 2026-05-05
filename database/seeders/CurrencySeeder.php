<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
  public function run(): void
  {
    $currencies = [
      [
        'code' => 'ZWL',
        'name' => 'Zimbabwean Dollar',
        'symbol' => 'ZWL',
        'exchange_rate' => 1.00,
        'is_active' => true,
        'is_default' => true,
        'description' => 'Zimbabwean Dollar - Default Currency',
      ],
      [
        'code' => 'USD',
        'name' => 'US Dollar',
        'symbol' => '$',
        'exchange_rate' => 0.002,
        'is_active' => true,
        'is_default' => false,
        'description' => 'United States Dollar',
      ],
      [
        'code' => 'ZAR',
        'name' => 'South African Rand',
        'symbol' => 'R',
        'exchange_rate' => 0.035,
        'is_active' => true,
        'is_default' => false,
        'description' => 'South African Rand',
      ],
      [
        'code' => 'GBP',
        'name' => 'British Pound',
        'symbol' => '£',
        'exchange_rate' => 0.0016,
        'is_active' => true,
        'is_default' => false,
        'description' => 'British Pound Sterling',
      ],
      [
        'code' => 'EUR',
        'name' => 'Euro',
        'symbol' => '€',
        'exchange_rate' => 0.0018,
        'is_active' => true,
        'is_default' => false,
        'description' => 'European Euro',
      ],
    ];

    foreach ($currencies as $currency) {
      Currency::updateOrCreate(
        ['code' => $currency['code']],
        $currency
      );
    }
  }
}
