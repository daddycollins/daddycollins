<?php

namespace Database\Factories;

use App\Models\Requirement;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequirementFactory extends Factory
{
  protected $model = Requirement::class;

  public function definition(): array
  {
    return [
      'title' => $this->faker->sentence(4),
      'description' => $this->faker->paragraph(),
      'category' => $this->faker->randomElement(['Plumbing', 'Electrical', 'Carpentry', 'Painting']),
      'deadline' => $this->faker->dateTimeBetween('+1 week', '+2 months'),
      'budget' => $this->faker->randomFloat(2, 50, 2000),
      'status' => 'open',
    ];
  }
}
