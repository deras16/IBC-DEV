<?php

namespace App\Enums;

enum MarketingTopic: string
{
    use CasesAsOptions;

    case SPORTS_AND_LIFESTYLE = 'Sports & Life Style';
    case MUSIC_STREAMING = 'Music Streaming';
    case TRAVEL_AND_HOSPITALITY = 'Travel & Hospitality';
    case FOOD_AND_BEVERAGE = 'Food & Beverage';
    case HEALTH_AND_WELLNESS = 'Health & Wellness';
    case FASHION_AND_BEAUTY = 'Fashion & Beauty';
    case TECHNOLOGY_AND_GADGETS = 'Technology & Gadgets';
    case ENTERTAINMENT_AND_MEDIA = 'Entertainment & Media';
    case AUTOMOTIVE = 'Automotive';
    case FINANCE_AND_BANKING = 'Finance & Banking';
}
