<?php

namespace App\Services;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Localisator
{
    public const BASE_URL = 'https://api-adresse.data.gouv.fr/search/';

    public function __construct(private HttpClientInterface $client)
    {}

    public function getLocalisation(string $address): array
    {
        $response = $this->client->request('GET', self::BASE_URL, [
            'query' => [
                'q' => $address,
            ],
        ]);

        return $response->toArray()['features'][0]['geometry']['coordinates'];
    }
}