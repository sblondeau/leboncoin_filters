<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Services\Localisator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class ProductFixtures extends Fixture
{
    const NUMBER = 200;
    const CITIES = [
        'Lille', 'Rennes', 'Brest', 'Bordeaux', 'Toulouse', 'Perpignan', 'Marseille', 'Nice', 'Metz', 'Chartres',
        'Grenoble', 'Lyon', 'Paris', 'Orléans', 'Limoges', 'Dijon', 'Nancy', 'Strasbourg', 'Reims', 'Nantes'
    ];

    public function __construct(private Localisator $localisator)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NUMBER; $i++) {
            $product = new Product();
            $product->setName($faker->words(asText: true))
                ->setPrice($faker->numberBetween(1, 10000))
                ->setIsUrgent($faker->boolean(10));
            $city = $faker->randomElement(self::CITIES);
            $product->setCity($city);
            if($i % 50 === 0) {
                sleep(1);
            }
            [$longitude, $latitude] = $this->localisator->getLocalisation($city);
            $product->setLongitude($longitude)->setLatitude($latitude);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
