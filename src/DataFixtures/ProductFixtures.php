<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    const NUMBER = 200;
    const CITIES = [
        'Lille', 'Rennes', 'Brest', 'Bordeaux', 'Toulouse', 'Perpignan', 'Marseille', 'Nice', 'Metz', 'Chartres',
        'Grenoble', 'Lyon', 'Paris', 'Orléans', 'Limoges', 'Dijon', 'Nancy', 'Strasbourg', 'Reims', 'Nantes'
    ];
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

            $manager->persist($product);
        }

        $manager->flush();
    }
}
