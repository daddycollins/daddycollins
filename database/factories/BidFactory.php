<?php

namespace Database\Factories;

use App\Models\Bid;
use Illuminate\Database\Eloquent\Factories\Factory;

class BidFactory extends Factory
{
  protected $model = Bid::class;

  public function definition(): array
  {
    return [
      'amount' => $this->faker->randomFloat(2, 50, 2000),
      'proposal' => $this->faker->sentence(10),
      'status' => 'pending',
    ];
  }
}
