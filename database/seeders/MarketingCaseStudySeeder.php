<?php

namespace Database\Seeders;

use App\Models\MarketingCaseStudy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarketingCaseStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MarketingCaseStudy::factory()->count(10)->create();
    }
}
