<?php

namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;


class SearchDto
{
    public ?string $search = null;

    #[Assert\Positive]
    #[Assert\LessThanOrEqual(propertyPath:'maxPrice')]

    public ?float $minPrice = null;

    #[Assert\GreaterThanOrEqual(propertyPath:'minPrice')]
    #[Assert\Positive]
    public ?float $maxPrice = null;

    public ?string $address = null;

    public ?int $radius = 5;

    public ?float $latitude = null;
    public ?float $longitude = null;

    public bool $isUrgent = false;

    public function generateQueryParameters(): array
    {
        return [
            'search' => $this->search,
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
            'isUrgent' => $this->isUrgent,
            'address' => $this->address,
            'radius' => $this->radius,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
