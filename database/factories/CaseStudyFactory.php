<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CaseStudy>
 */
class CaseStudyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => $this->faker->company(),
            'space_topic' => $this->faker->randomElement(['Ai', 'Memecoin', 'Defi', 'RWA', 'Gaming', 'NFT', 'Web3', 'SocialFi', 'Countdown']),
            'space_type' => $this->faker->randomElement(['SS on M', 'Video on M', 'SS on RT', 'Video on RT']),
            'space_title' => $this->faker->sentence(6),
            'date' => $this->faker->date(),
        ];
    }
}
