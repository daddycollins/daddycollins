<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Requirement;
use App\Models\User;

class RequirementSeeder extends Seeder
{
  public function run(): void
  {
    // Get a few clients (users)
    $clients = User::where('role', 'client')->take(3)->get();
    if ($clients->isEmpty()) {
      // fallback: just use first 3 users
      $clients = User::take(3)->get();
    }
    foreach ($clients as $client) {
      Requirement::factory()->count(3)->create([
        'user_id' => $client->id,
      ]);
    }
  }
}
