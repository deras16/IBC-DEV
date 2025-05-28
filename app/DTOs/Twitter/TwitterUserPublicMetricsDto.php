<?php

namespace App\DTOs\Twitter;

class TwitterUserPublicMetricsDto
{
    public function __construct(
        public readonly int $followers_count,
        public readonly int $following_count,
        public readonly int $tweet_count,
        public readonly int $listed_count,
        public readonly int $like_count,
        public readonly int $media_count,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['followers_count'],
            $data['following_count'],
            $data['tweet_count'],
            $data['listed_count'],
            $data['like_count'],
            $data['media_count'],
        );
    }
}
