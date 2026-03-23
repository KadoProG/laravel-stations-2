<?php

namespace Database\Factories;

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
            // TODO: 公開年、説明、上映中かどうかを追加する
            // 'published_year' => $this->faker->year,
            // 'description' => $this->faker->realText(20),
            // 'is_showing' => $this->faker->boolean,
        ];
    }
}
