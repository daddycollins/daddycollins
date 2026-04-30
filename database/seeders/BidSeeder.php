<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bid;
use App\Models\Requirement;
use App\Models\User;

class BidSeeder extends Seeder
{
  public function run(): void
  {
    $artisans = User::where('role', 'artisan')->take(5)->get();
    if ($artisans->isEmpty()) {
      $artisans = User::take(5)->get();
    }
    $requirements = Requirement::all();
    foreach ($requirements as $requirement) {
      foreach ($artisans->random(min(2, $artisans->count())) as $artisan) {
        Bid::factory()->create([
          'requirement_id' => $requirement->id,
          'artisan_id' => $artisan->id,
        ]);
      }
    }
  }
}
