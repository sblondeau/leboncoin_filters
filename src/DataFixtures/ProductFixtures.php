<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    const NUMBER = 100;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NUMBER; $i++) {
            $product = new Product();
            $product->setName($faker->words(asText: true))
                ->setPrice($faker->numberBetween(1, 10000))
                ->setIsUrgent($faker->boolean(10));

            $manager->persist($product);
        }

        $manager->flush();
    }
}
