<?php

namespace App\DataFixtures;

use App\Entity\Rate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RateFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $rates = [
            [
                'price' => 3500.565,
                'date' => new \DateTime('2022-02-02 00:00:00')
            ],
            [
                'price' => 4000.757,
                'date' => new \DateTime('2022-02-02 01:00:00')
            ],
            [
                'price' => 4500.434,
                'date' => new \DateTime('2022-02-02 02:00:00')
            ],
            [
                'price' => 5100.141,
                'date' => new \DateTime('2022-02-02 03:00:00')
            ],
            [
                'price' => 6200.858,
                'date' => new \DateTime('2022-02-02 04:00:00')
            ]
        ];

        foreach ($rates as $rate) {
            foreach (CurrencyFixtures::CURRENCY_REFERENCES as $reference) {
                $newRate = new Rate();
                $newRate->setPrice($rate['price']);
                $newRate->setDate($rate['date']);
                $newRate->setCurrency($this->getReference($reference));
                $manager->persist($newRate);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CurrencyFixtures::class,
        ];
    }
}
