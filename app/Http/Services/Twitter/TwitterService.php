<?php

namespace App\Http\Services\Twitter;

use App\DTOs\Twitter\TwitterUserResponseDto;

class TwitterService
{
    public function __construct(protected TwitterClient $client) {}

    public function getUserDataByUsername(string $username): TwitterUserResponseDto
    {
        return $this->client->getUserByUsername($username);
    }
}
