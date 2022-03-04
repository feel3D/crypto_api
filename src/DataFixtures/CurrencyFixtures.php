<?php

namespace App\DataFixtures;

use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyFixtures extends Fixture
{
    public const USD = 'USD';
    public const EURO = 'EUR';
    public const RUB = 'RUB';

    public const CURRENCY_REFERENCES = [
        self::USD,
        self::EURO,
        self::RUB,
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CURRENCY_REFERENCES as $reference) {
            $currency = new Currency();
            $currency->setCode($reference);
            $manager->persist($currency);
            $this->addReference($reference, $currency);
        }
        $manager->flush();
    }
}
