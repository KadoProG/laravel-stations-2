<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'title' => $this->faker->unique()->word,
      'image_url' => $this->faker->imageUrl(),
      'published_year' => $this->faker->numberBetween(0, 2025),
      'is_showing' => $this->faker->randomElement([true, false]),
      'description' => $this->faker->unique()->word,
      'genre_id' => Genre::inRandomOrder()->first()->id,
    ];
  }
}
