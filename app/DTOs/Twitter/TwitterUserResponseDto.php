<?php

namespace App\DTOs\Twitter;

class TwitterUserResponseDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $username,
        public readonly TwitterUserPublicMetricsDto $public_metrics,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['username'],
            TwitterUserPublicMetricsDto::fromArray($data['public_metrics'])
        );
    }
}
