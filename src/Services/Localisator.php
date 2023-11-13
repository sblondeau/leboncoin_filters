<?php

namespace App\Services;

use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\Exception\ClientException;

class Localisator
{
    public const BASE_URL = 'https://api-adresse.data.gouv.fr/search/';

    public function __construct(private HttpClientInterface $client)
    {
    }

    public function getLocalisation(?string $address): array
    {

        $response = $this->client->request('GET', self::BASE_URL, [
            'query' => [
                'q' => $address,
            ],
        ]);

        return $response->toArray()['features'][0]['geometry']['coordinates'] ?? [];
    }


    public function getCities(?string $address): array
    {
        $cities = [];
        if (strlen($address) > 2) {
            if ($address) {
                $response = $this->client->request('GET', self::BASE_URL, [
                    'query' => [
                        'q' => $address,
                        'type' => 'municipality',
                        'limit' => 10,
                        'autocomplete' => 1,
                    ],
                ]);


                $results = $response->toArray()['features'];
                foreach ($results as $result) {
                    $cities[] = $result['properties']['municipality'];
                }
            }
        }
        return array_unique($cities);
    }
}
