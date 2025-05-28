<?php

namespace App\Http\Services\Twitter;

use App\DTOs\Twitter\TwitterUserResponseDto;
use Illuminate\Support\Facades\Http;

class TwitterClient
{
    protected string $baseUrl;
    protected string $bearerToken;

    public function __construct()
    {
        $this->baseUrl = config('services.twitter.base_url');
        $this->bearerToken = config('services.twitter.bearer_token');
    }

    public function getUserByUsername(string $username): TwitterUserResponseDto
    {
        $response =  $this->genericConsumer()
            ->get("users/by/username/{$username}?user.fields=public_metrics")
            ->throw()
            ->json();
        return TwitterUserResponseDto::fromArray($response['data'] ?? []);
    }

    private function genericConsumer()
    {
        return Http::withToken($this->bearerToken)
            ->baseUrl($this->baseUrl);
    }

}
