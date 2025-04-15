<?php

namespace Database\Factories;

use App\Enums\MarketingTopic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MarketingCaseStudy>
 */
class MarketingCaseStudyFactory extends Factory
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
            'client_description' => $this->faker->sentence(10),
            'marketing_case_topic' => $this->faker->randomElement(['Sports & Life Style', 'Music Streaming', 'Travel & Hospitality', 'Food & Beverage', 'Health & Wellness', 'Fashion & Beauty', 'Technology & Gadgets', 'Entertainment & Media', 'Automotive', 'Finance & Banking']),
            'date' => $this->faker->date(),
            'views' => $this->faker->numberBetween(50000, 500000),
            'impressions' => $this->faker->numberBetween(100000, 1000000),
            'listeners' => $this->faker->numberBetween(10000, 500000),
            'followers' => $this->faker->numberBetween(1000, 100000),
        ];
    }
}
