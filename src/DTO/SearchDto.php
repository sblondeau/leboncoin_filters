<?php

namespace App\DTO;
use App\Services\Localisable;
use Symfony\Component\Validator\Constraints as Assert;


class SearchDto implements Localisable
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

    /**
     * Get the value of latitude
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * Get the value of longitude
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }
}
