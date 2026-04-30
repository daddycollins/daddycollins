<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ArtisanProfile;
use Illuminate\Database\Seeder;

class ArtisanProfileSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Get the artisan user
    $artisanUser = User::where('role', 'artisan')->first();

    if (!$artisanUser) {
      return;
    }

    // Create artisan profile for the seeded artisan user
    ArtisanProfile::create([
      'user_id' => $artisanUser->id,
      'category' => 'Plumbing',
      'location' => 'Harare, Zimbabwe',
      'verified' => true,
      'business_name' => 'John\'s Plumbing Services',
      'phone' => '+263787654321',
      'bio' => 'Professional plumber with 10+ years of experience in residential and commercial plumbing services.',
    ]);

    // Create additional artisan users and profiles for testing
    $categories = ['Electrical', 'Carpentry', 'Welding', 'Painting', 'Masonry', 'HVAC'];
    $locations = ['Bulawayo', 'Mutare', 'Gweru', 'Chitungwiza', 'Epworth', 'Norton'];

    foreach ($categories as $key => $category) {
      $user = User::create([
        'name' => ucfirst($category) . ' Expert ' . ($key + 2),
        'email' => strtolower($category) . $key . '@artisanconnect.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        'role' => 'artisan',
        'status' => $key % 3 === 0 ? 'suspended' : 'active',
        'email_verified_at' => now(),
      ]);

      ArtisanProfile::create([
        'user_id' => $user->id,
        'category' => $category,
        'location' => $locations[$key],
        'verified' => $key % 2 === 0,
        'business_name' => ucfirst($category) . ' Solutions ' . ($key + 1),
        'phone' => '+2637876543' . str_pad($key, 2, '0', STR_PAD_LEFT),
        'bio' => 'Expert in ' . strtolower($category) . ' services with proven track record and customer satisfaction.',
      ]);
    }
  }
}
