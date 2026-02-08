<?php

namespace Database\Seeders;

use App\Models\ArtisanService;
use App\Models\ArtisanProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtisanServiceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Get the first artisan (John Artisan)
    $artisan = ArtisanProfile::first();

    if ($artisan) {
      ArtisanService::create([
        'artisan_id' => $artisan->id,
        'service_name' => 'Pipe Installation & Repair',
        'description' => 'Professional pipe installation and repair services for residential and commercial properties',
        'price_estimate' => 250.00
      ]);

      ArtisanService::create([
        'artisan_id' => $artisan->id,
        'service_name' => 'Bathroom Fixtures Installation',
        'description' => 'Expert installation of bathroom fixtures including sinks, toilets, and showers',
        'price_estimate' => 350.00
      ]);

      ArtisanService::create([
        'artisan_id' => $artisan->id,
        'service_name' => 'Water Leakage Detection',
        'description' => 'Advanced leak detection and diagnosis services to identify water problems',
        'price_estimate' => 150.00
      ]);
    }
  }
}
