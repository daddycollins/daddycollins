<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\ArtisanService;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Get client and artisan users
    $clientUser = User::where('role', 'client')->first();
    $artisanUsers = User::where('role', 'artisan')->get();

    if (!$clientUser || $artisanUsers->isEmpty()) {
      return;
    }

    $statuses = ['pending', 'processing', 'completed', 'cancelled'];
    $paymentStatuses = ['pending', 'confirmed', 'failed'];
    $services = ['Plumbing Repair', 'Electrical Wiring', 'Carpentry Work', 'House Painting', 'Wall Masonry', 'HVAC Installation'];

    // Create 20 orders
    for ($i = 1; $i <= 20; $i++) {
      $artisan = $artisanUsers->random();
      $status = $statuses[array_rand($statuses)];
      $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];
      $amount = rand(500, 5000);

      $order = Order::create([
        'client_id' => $clientUser->id,
        'artisan_id' => $artisan->artisanProfile?->id ?? $artisanUsers->first()->artisanProfile?->id,
        'amount' => $amount,
        'status' => $status,
        'payment_status' => $paymentStatus,
        'created_at' => now()->subDays(rand(0, 30)),
        'updated_at' => now()->subDays(rand(0, 30)),
      ]);

      // Create associated artisan service record
      ArtisanService::create([
        'artisan_id' => $artisan->artisanProfile?->id ?? $artisanUsers->first()->artisanProfile?->id,
        'service_name' => $services[array_rand($services)],
      ]);
    }
  }
}
